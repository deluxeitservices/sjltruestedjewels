<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Services\PricingService;

class ProductController extends Controller
{
    public function show(string $slug, PricingService $pricing){
        $product = Product::where('slug',$slug)->with('priceRule')->firstOrFail();
        $price = $pricing->priceFor($product);
        return view('pages.product', compact('product','price'));
    }
}
