<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\PricingService;
use App\Services\ExternalProductsService;

class CartController extends Controller
{
    // app/Http/Controllers/CartController.php

        public function index(CartService $svc, PricingService $pricing, ExternalProductsService $ext)
        {
            $cart   = $svc->getOrCreateCart();
            $totals = $svc->totalsExternal($cart, $pricing, $ext);
            // echo "<pre>";
            // print_r($totals); exit();
            // If your blade currently reads $cart->items, you can pass both
            return view('pages.cart', [
                'cart'   => $cart,   // for raw relations if needed
                'totals' => $totals, // for enriched items + totals
            ]);
        }

        

    public function add(Request $r, CartService $svc){
        echo $r->qty; exit();
        $r->validate(['product_id'=>'required|integer','qty'=>'nullable|integer|min:1']);
        $svc->addProduct((int)$r->product_id, (int)($r->qty ?? 1));
        return redirect()->route('cart.index');
    }
    public function addFromGet(Request $r, CartService $svc)
    {
        $productId = (int)$r->query('product_id');
        $qty       = max(1,(int)$r->query('qty',1));
        if ($productId <= 0) return back()->with('error','Missing product_id');
        $svc->addProduct($productId, $qty);
        return redirect()->route('cart.index');
    }
    public function update(Request $r, CartService $svc){
        $r->validate(['item_id'=>'required|integer','qty'=>'required|integer']);
        $svc->updateQty((int)$r->item_id,(int)$r->qty);
        return back();
    }
    public function remove(Request $r, CartService $svc){
        $r->validate(['item_id'=>'required|integer']);
        $svc->removeItem((int)$r->item_id);
        return back();
    }
    public function price(CartService $svc,PricingService $pricing, ExternalProductsService $ext)
    {
        $cart = $svc->getOrCreateCart();
        return response()->json($svc->totalsExternal($cart, $pricing, $ext));
    }

    public function updateAjax(
    Request $r,
    \App\Services\CartService $svc,
    PricingService $pricing,
    ExternalProductsService $extSvc
    ) {
        $data = $r->validate([
            'item_id' => 'required|integer',
            'qty'     => 'required|integer|min:0',
        ]);

        if ((int)$data['qty'] === 0) {
            $svc->removeItem((int)$data['item_id']);
        } else {
            $svc->updateQty((int)$data['item_id'], (int)$data['qty']);
        }

        $cart   = $svc->getOrCreateCart();
        $totals = $svc->totalsExternal($cart, $pricing, $extSvc); // returns all lines + totals

        return response()->json($totals);
    }

    public function removeAjax(
        Request $r,
        \App\Services\CartService $svc,
        PricingService $pricing,
        ExternalProductsService $extSvc
    ) {
        $data = $r->validate(['item_id' => 'required|integer']);

        $svc->removeItem((int)$data['item_id']);

        $cart   = $svc->getOrCreateCart();
        $totals = $svc->totalsExternal($cart, $pricing, $extSvc);

        return response()->json($totals);
    }
    // public function price(CartService $svc, PricingService $pricing){
    //     $cart = $svc->getOrCreateCart();
    //     return response()->json($svc->totals($cart, $pricing));
    // }
}
