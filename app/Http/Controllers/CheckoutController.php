<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\CartService;
use App\Services\PricingService;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\UserAddress;
use App\Services\ExternalProductsService;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB; 



class CheckoutController extends Controller
{
    public function checkout(Request $r, CartService $cartSvc, PricingService $pricing)
    {
        $r->validate(['email' => 'required|email', 'name' => 'required|string']);
        $cart = $cartSvc->getOrCreateCart()->load('items.product.priceRule');
        if ($cart->items()->count() === 0) return back()->with('error', 'Your cart is empty.');

        $subtotal = 0.0;
        $vat = 0.0;
        $lines = [];
        foreach ($cart->items as $ci) {
            $p = $ci->product;
            $unit = $pricing->priceFor($p) ?? 0.0;
            $line = round($unit * $ci->quantity, 2);
            $vatRate = $pricing->vatRateFor($p);
            $ex = $line / (1 + $vatRate);
            $subtotal += $ex;
            $vat += $line - $ex;
            $lines[] = ['product_id' => $p->id, 'title' => $p->title, 'metal' => $p->metal, 'weight_g' => $p->weight_g, 'qty' => $ci->quantity, 'unit' => $unit, 'vat_rate' => $vatRate, 'line' => $line];
        }
        $total = round($subtotal + $vat, 2);

        $order = Order::create([
            'cart_id' => $cart->id,
            'order_no' => 'ORD-' . Str::upper(Str::random(8)),
            'status' => 'pending',
            'currency' => 'GBP',
            'subtotal_gbp' => round($subtotal, 2),
            'vat_gbp' => round($vat, 2),
            'total_gbp' => $total,
            'customer_email' => $r->email,
            'customer_name' => $r->name,
            'lock_expires_at' => now()->addMinutes(10),
        ]);
        foreach ($lines as $L) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $L['product_id'],
                'title' => $L['title'],
                'metal' => $L['metal'],
                'weight_g' => $L['weight_g'],
                'qty' => $L['qty'],
                'unit_price_gbp' => $L['unit'],
                'vat_rate' => $L['vat_rate'],
                'vat_gbp' => round($L['line'] - ($L['line'] / (1 + $L['vat_rate'])), 2),
                'line_total_gbp' => $L['line']
            ]);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $lineItems = [];
        foreach ($order->items as $it) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => ['name' => $it->title],
                    'unit_amount' => (int)round($it->unit_price_gbp * 100),
                ],
                'quantity' => $it->qty,
            ];
        }
        $session = \Stripe\Checkout\Session::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'customer_email' => $order->customer_email,
            'metadata' => ['order_id' => (string)$order->id],
            'success_url' => url('/checkout/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/cart'),
            //'expires_at'=>$order->lock_expires_at->timestamp,
        ]);
        $order->checkout_session_id = $session->id;
        $order->save();
        return redirect($session->url);
    }

    // public function success(Request $r){
    //     $sid=$r->query('session_id'); if(!$sid) return redirect('/')->with('error','Missing session.');
    //     \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    //     $s=\Stripe\Checkout\Session::retrieve($sid);
    //     $orderId=$s->metadata['order_id']??null; if(!$orderId) return redirect('/')->with('error','Order not found.');
    //     $order=\App\Models\Order::findOrFail($orderId);
    //     if($s->payment_status==='paid'){
    //         $order->status='paid'; $order->paid_at=now(); $order->save();
    //         if($order->cart_id){ $c=Cart::find($order->cart_id); if($c){ $c->status='completed'; $c->save(); } }
    //     }
    //     $metal='XAU';
    //     return view('pages.orders.confirmation', compact('order','metal'));
    // }

    public function show(CartService $svc, PricingService $pricing, ExternalProductsService $extSvc)
    {
        $cart   = $svc->getOrCreateCart();
        $totals = $svc->totalsExternal($cart, $pricing, $extSvc);
        if (empty($totals['items'])) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Create a PaymentIntent (Stripe)
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $amount = (int) round($totals['total'] * 100); // in pence

        $pi = \Stripe\PaymentIntent::create([
            'amount'   => $amount,
            'currency' => 'gbp',
            // Either let Stripe decide all available methods:
            'automatic_payment_methods' => ['enabled' => true],
            'metadata' => [
                'cart_id' => (string)$cart->id,
                'user_id' => (string)Auth::id(),
            ],
            // Or restrict to card + Klarna explicitly:
            // 'payment_method_types' => ['card','klarna'],
        ]);
        session([
            'pi_id'   => $pi->id,
            'cart_id' => $cart->id,
        ]);

        $defaultAddress = UserAddress::where('user_id', auth()->id())
            ->where('default_address', true)
            ->first();

        $savedCartAddress = UserAddress::where('user_id', auth()->id())
            ->where('id', $cart->address_id)
            ->first();

            // echo '<pre>';
            // print_r($savedCartAddress);
            // die;
        return view('checkout.show', [
            'savedCartAddress'   => $savedCartAddress,
            'cart_id'   => $cart->id,
            'order_note'   => $cart->order_note,
            'clientSecret'   => $pi->client_secret,
            'publishableKey' => config('services.stripe.key'),
            'totals'         => $totals,
            'defaultAddress'         => $defaultAddress,
        ]);
    }

    public function success(
        Request $request,
        CartService $carts,
        PricingService $pricing,
        ExternalProductsService $extSvc
    ) {
        $stripe = new StripeClient(config('services.stripe.secret'));

        // Resolve PI
        $clientSecret = $request->get('payment_intent_client_secret');
        $piId = session('pi_id');
        if ($clientSecret && preg_match('/^(pi_[^_]+)/', $clientSecret, $m)) {
            $piId = $m[1];
        }
        if (!$piId) {
            return redirect()->route('checkout.show')->with('error', 'Payment not found.');
        }

        $pi = $stripe->paymentIntents->retrieve($piId, []);
        if ($pi->status !== 'succeeded') {
            return redirect()->route('checkout.show')->with('error', 'Payment is not completed.');
        }

        $addressId = $request->input('address_id');
        if($addressId){
            $billingAddressId = UserAddress::where('user_id', auth()->id())
                        ->where('id', $addressId)
                        ->value('id');

        }else{
            $billingAddressId = UserAddress::where('user_id', auth()->id())
                        ->where('default_address', true)
                        ->value('id');

        }

        

        // Totals & items from cart
        $cart   = $carts->getOrCreateCart();
        $totals = $carts->totalsExternal($cart, $pricing, $extSvc);
        $items  = $totals['items'] ?? [];

        // Billing
        $charge  = $pi->charges->data[0] ?? null;
        $billing = $charge ? $charge->billing_details : null;

        // Create order
        $order = Order::create([
            'cart_id'            => $cart->id,
            'order_no'           => 'SJL-' . strtoupper(Str::random(8)),
            'status'             => 'paid',
            'currency'           => strtoupper($pi->currency ?? 'GBP'),
            'subtotal_gbp'       => $totals['subtotal'],
            'vat_gbp'            => $totals['vat'],
            'total_gbp'          => $totals['total'],
            'customer_email'     => Auth::user()->email ?? ($billing->email ?? null),
            'customer_name'      => Auth::user()->name  ?? ($billing->name  ?? null),
            'payment_intent_id'  => $pi->id,
            'checkout_session_id' => null,
            'paid_at'            => now(),
            'lock_expires_at'    => now()->addMinutes(15),
            'user_id'            => (string)Auth::id(),
            'customer_address_id' => $billingAddressId,
        ]);

        // Persist each line as an order item
        foreach ($items as $it) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $it['product_id']  ?? null,
                'external_id'   => $it['external_id'] ?? null,   // <-- you asked to keep external id
                'title'         => $it['title']       ?? 'Item',
                'qty'           => (int)($it['qty']   ?? 1),
                'unit_gbp'      => (float)($it['unit']      ?? 0),
                'line_gbp'      => (float)($it['line']      ?? 0),
                'unit_net_gbp'  => (float)($it['unit_net']  ?? 0),
                'unit_vat_gbp'  => (float)($it['unit_vat']  ?? 0),
                'line_net_gbp'  => (float)($it['line_net']  ?? 0),
                'line_vat_gbp'  => (float)($it['line_vat']  ?? 0),
                'image_url'     => $it['image'] ?? null,         // if you included image in totals
            ]);
        }

        // Close cart
        $cart->status = 'completed';
        $cart->save();
        // Optionally: $cart->items()->delete();

        session()->forget(['pi_id', 'cart_id']);

        // Load order with items for display
        $order->load('items', 'user'); // ensure you add a relation in Order model


        // $order->load('items', 'user');
        $adminEmail = env('MAIL_ADMIN_ADDRESS', config('mail.from.address'));
        $declarationUrl = route('orders.declaration', ['order' => $order->id]);

        // Customer (attach PDF optional: true/false)
        Mail::to($order->customer_email)->send(new OrderPlaced($order, toAdmin: false, attachPdf: false, declarationUrl: $declarationUrl));
        // Admin notification
        Mail::to($adminEmail)->send(new OrderPlaced($order, toAdmin: true, attachPdf: false));

        return view('checkout.success', [
            'order'  => $order,
            'totals' => $totals,
            'declarationUrl' => $declarationUrl,
        ]);
    }

    public function cancel()
    {
        return redirect()->route('cart.index')->with('error', 'Payment canceled.');
    }


    public function addresStore(Request $request)
    {

        $data = $request->validate([
            // 'name'        => ['required', 'string', 'max:255'],
            // 'phone'       => ['nullable', 'string', 'max:50'],
            'address'     => ['required', 'string', 'max:255'],
            'house_no'    => ['required', 'string', 'max:255'],
            'street_name' => ['nullable', 'string', 'max:255'],
            'city'        => ['required', 'string', 'max:120'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country'     => ['required', 'string'],
            'make_default' => ['sometimes', 'boolean'],
        ]);

        $cart_id = $request->input('cart_id');
        $order_note = $request->input('order_note');
        $address_id = $request->input('address_id');
        $userId = $request->user()->id;
        if (!empty($address_id)) {
            // UPDATE existing address (owned by this user)
            $address = UserAddress::where('user_id', $userId)
                ->where('id', $address_id)
                ->firstOrFail();

            // unset($data['address_id']);
            // $address->update($data);
            $mode = 'updated';
        } else {
             UserAddress::where('user_id', $userId)->update(['default_address' => false]);
            // CREATE new address
            $address = UserAddress::create($data + [
                'user_id'          => $userId,
                'default_address'  => true,
            ]);
        }

        DB::table('carts')->where('id', $cart_id)->update(
            [
                'address_id' => $address->id,
                'order_note' => $order_note
            ]);

        // UserAddress::where('user_id', $userId)->update(['default_address' => false]);

        // $addr = UserAddress::create($data + ['user_id' => $userId]);
        return response()->json([
            'ok' => true,
            'address_id' => $address->id,
            'is_default' => (bool)$address->default_address,
        ]);
    }
}
