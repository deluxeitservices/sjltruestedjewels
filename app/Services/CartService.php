<?php
namespace App\Services;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    // public function getOrCreateCart(): Cart {
    //     $sid = Session::getId();
    //     return Cart::firstOrCreate(['session_id'=>$sid,'status'=>'open'], ['user_id'=>null]);
    // }
    public function getOrCreateCart(): Cart
    {
        $sid    = Session::getId();
        $userId = Auth::id();

        if ($userId) {
            // User's open cart (create if missing)
            $userCart = Cart::firstOrCreate(
                ['user_id' => $userId, 'status' => 'open'],
                ['session_id' => $sid]
            );

            // If we have a remembered guest cart id, merge it now
            if ($guestId = session('guest_cart_id')) {
                $guestCart = Cart::where('id', $guestId)
                    ->whereNull('user_id')
                    ->where('status', 'open')
                    ->with('items')
                    ->first();

                if ($guestCart && $guestCart->id !== $userCart->id) {
                    $this->mergeCarts($guestCart, $userCart);
                    // Clean up guest cart
                    $guestCart->items()->delete();
                    $guestCart->delete();
                }
                session()->forget('guest_cart_id');
            }

            // Keep session_id fresh on the user cart
            if ($userCart->session_id !== $sid) {
                $userCart->session_id = $sid;
                $userCart->save();
            }

            return $userCart->load('items');
        }

        // Guest flow: ensure we have a cart tied to current session
        $guestCart = Cart::firstOrCreate(
            ['session_id' => $sid, 'status' => 'open'],
            ['user_id' => null]
        );


        // Remember the guest cart id in session so we can find it after login
        session()->put('guest_cart_id', $guestCart->id);

        return $guestCart->load('items');
    }
    // public function addProduct(int $productId, int $qty=1): Cart {
    //     $cart = $this->getOrCreateCart();
    //     $item = $cart->items()->where('product_id',$productId)->first();
    //     if ($item){ $item->quantity += $qty; $item->save(); }
    //     else { CartItem::create(['cart_id'=>$cart->id,'product_id'=>$productId,'quantity'=>$qty]); }
    //     return $cart->fresh('items.product');
    // }
    /**
     * Example addProduct that also remembers guest_cart_id for later merge.
     */
    public function addProduct(int $productId, int $qty = 1, ?int $externalId = null): void
    {
        $cart = $this->getOrCreateCart();

        $item = $cart->items()
            ->where(function ($q) use ($productId, $externalId) {
                if ($externalId) $q->orWhere('external_id', $externalId);
                if ($productId)  $q->orWhere('product_id', $productId);
            })
            ->first();

        if ($item) {
            $item->qty = (int)($item->qty ?? $item->quantity ?? 0) + max(1, $qty);
            $item->save();
        } else {
            $cart->items()->create([
                'product_id'  => $productId,
                'external_id' => $externalId,
                'quantity'         => max(1, $qty),
            ]);
        }

        // ensure the current guest cart is remembered for post-login merge
        session()->put('guest_cart_id', $cart->id);
    }
    public function updateQty(int $itemId, int $qty): Cart {
        $cart = $this->getOrCreateCart();
        $it = $cart->items()->where('id',$itemId)->firstOrFail();
        if ($qty<=0) $it->delete(); else { $it->quantity=$qty; $it->save(); }
        return $cart->fresh('items.product');
    }
    public function removeItem(int $itemId): Cart {
        $cart = $this->getOrCreateCart(); $cart->items()->where('id',$itemId)->delete(); return $cart->fresh('items.product');
    }
    public function totals(Cart $cart, PricingService $pricing): array
    {
        // Make sure we have products + price rules loaded
        $cart->loadMissing('items.product.priceRule');

        $lines    = [];
        $grand    = 0.0;

        foreach ($cart->items as $item) {
            $product = $item->product;

            // Guard: skip bad rows instead of crashing
            if (!$product) {
                \Log::warning('Cart item missing product', ['item_id' => $item->id]);
                continue;
            }

            // Your priceFor() returns VAT-inclusive gross
            $unit = $pricing->priceFor($product);
            if ($unit === null) {
                \Log::warning('No price for product', ['item_id' => $item->id, 'product_id' => $product->id]);
                continue;
            }

            $qty   = max(1, (int) $item->qty);
            $line  = $unit * $qty;
            $grand += $line;

            $lines[] = [
                'item_id'     => $item->id,
                'product_id'  => $product->id,
                'title'       => $product->title,
                'qty'         => $qty,
                'unit_gbp'    => round($unit, 2),
                'line_gbp'    => round($line, 2),
            ];
        }

        return [
            'items'      => $lines,
            'total_gbp'  => round($grand, 2), // VAT already included by priceFor()
        ];
    }
   public function totalsExternal(
    Cart $cart,
    \App\Services\PricingService $pricing,
    \App\Services\ExternalProductsService $extSvc
): array {
    $cart->loadMissing('items.product');

    // Batch fetch external products for the cart
    $extIds = [];
    foreach ($cart->items as $it) {
        $extId = $it->external_id ?: $it->product_id;
        if ($extId) $extIds[] = (int)$extId;
    }
    $extMap = !empty($extIds) ? $extSvc->fetchByIds($extIds, $pricing) : [];

    $items    = [];
    $linesOut = [];
    $subtotal = 0.0; // ex-VAT
    $vatTotal = 0.0;
    $grand    = 0.0;

    $distinct = 0;
    $qtySum   = 0;

    foreach ($cart->items as $it) {
        $qty = (int)($it->qty ?? $it->quantity ?? 1);
        if ($qty < 1) $qty = 1;

        $distinct++;
        $qtySum += $qty;

        $extId = $it->external_id ?: $it->product_id;

        $title       = $it->product->title ?? 'Item';
        $frontMetal  = $it->product->metal ?? null;
        $weightG     = $it->product->weight_g ?? null;
        $vatRateDec  = 0.0;
        $imageUrl    = null; // <-- we’ll fill this

        // Price (per-unit, VAT-inclusive). If your compute returns total-for-qty, normalize.
        $unitGross = null;

        if ($extId && isset($extMap[(int)$extId])) {
            $ext        = $extMap[(int)$extId];
            $title      = $ext['front_title'] ?? $title;
            $frontMetal = $ext['front_metal']['name'] ?? $frontMetal;
            $weightG    = $ext['weight_g'] ?? $weightG;

            // IMAGE from external API
            $imageUrl = $ext['primary_image']['url']
                ?? ($ext['images'][0]['url'] ?? null);

            $lineTotalForQty = $extSvc->computeUnitPriceGBP($ext, $pricing, $qty);
            if ($lineTotalForQty !== null) {
                $unitGross = (float)$lineTotalForQty / $qty;
            }

            if (isset($ext['vat_rate']) && $ext['vat_rate'] !== null) {
                $vatRateDec = ((float)$ext['vat_rate']) / 100.0;
            }
        }

        // Fallbacks
        if (!$imageUrl && $it->product && !empty($it->product->image_url)) {
            // if your Product model has image_url, use it
            $imageUrl = $it->product->image_url;
        }
        if (!$imageUrl) {
            // final fallback placeholder (adjust path to your asset)
            $imageUrl = asset('assets/images/placeholder-bar.svg');
        }

        if ($unitGross === null && $it->product) {
            $unitGross = $pricing->priceFor($it->product);    // VAT-inclusive unit price
            $vatRateDec = $pricing->vatRateFor($it->product); // decimal e.g. 0.20
        }
        if ($unitGross === null) {
            \Log::warning('No price for cart item', ['item_id'=>$it->id,'external_id'=>$extId]);
            continue;
        }

        // Split per-unit net/VAT
        $unitNet = $vatRateDec > 0 ? ($unitGross / (1 + $vatRateDec)) : $unitGross;
        $unitVat = $unitGross - $unitNet;

        // Line totals
        $lineGross = $unitGross * $qty;
        $lineNet   = $unitNet   * $qty;
        $lineVat   = $unitVat   * $qty;

        $subtotal += $lineNet;
        $vatTotal += $lineVat;
        $grand    += $lineGross;

        $items[] = [
            'item_id'     => $it->id,
            'external_id' => $extId,
            'product_id'  => $it->product_id,
            'title'       => $title,
            'front_metal' => $frontMetal,
            'weight_g'    => $weightG,
            'qty'         => $qty,

            // NEW: image for display
            'image'       => $imageUrl,

            // per-unit
            'unit'        => round($unitGross, 2),
            'unit_net'    => round($unitNet, 2),
            'unit_vat'    => round($unitVat, 2),

            // line
            'line'        => round($lineGross, 2),
            'line_net'    => round($lineNet, 2),
            'line_vat'    => round($lineVat, 2),
        ];

        $linesOut[] = [
            'id'   => $extId,
            'unit' => round($unitGross, 2),
            'line' => round($lineGross, 2),
        ];
    }

    return [
        'items'          => $items,
        'lines'          => $linesOut,
        'subtotal'       => round($subtotal, 2), // ex-VAT
        'vat'            => round($vatTotal, 2),
        'total'          => round($grand, 2),    // inc-VAT
        'distinct_items' => $distinct,
        'total_quantity' => $qtySum,
    ];
}


    public function addExternal(int $externalId, int $qty = 1): void
    {
        $cart = $this->getOrCreateCart();

        $item = $cart->items()->where('product_id', $externalId)->first();

        if ($item) {
            $item->quantity += $qty;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id'  => $externalId, // store external id
                'quantity'         => $qty,
            ]);
        }
    }



    /**
     * Merge $from into $into (sum quantities of same product/external).
     * Uses a transaction for safety.
     */
    protected function mergeCarts(Cart $from, Cart $into): void
    {
        DB::transaction(function () use ($from, $into) {
            $into->load('items');
            foreach ($from->items as $fi) {
                // Prefer matching by external_id if present; else by product_id
                $query = $into->items()->newQuery();
                $query->where(function ($q) use ($fi) {
                    if (!empty($fi->external_id)) {
                        $q->orWhere('external_id', $fi->external_id);
                    }
                    if (!empty($fi->product_id)) {
                        $q->orWhere('product_id', $fi->product_id);
                    }
                });

                /** @var CartItem|null $match */
                $match = $query->first();

                if ($match) {
                    $match->quantity = (int)($match->qty ?? $match->quantity ?? 0) + (int)($fi->qty ?? $fi->quantity ?? 0);
                    // Keep any other attributes you care about (options, notes, etc.)
                    $match->save();
                } else {
                    $into->items()->create([
                        'product_id'  => $fi->product_id,
                        'external_id' => $fi->external_id,
                        'quantity'         => (int)($fi->qty ?? $fi->quantity ?? 1),
                        // copy other fields you store on items if needed…
                    ]);
                }
            }

            // Finally attach the merged cart to the user/session (if needed)
            if ($into->user_id === null && Auth::id()) {
                $into->user_id = Auth::id();
            }
            $into->session_id = Session::getId();
            $into->save();
        });
    }

    
}
