<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\PricingService;

class CatalogController extends Controller
{
    public function index(Request $r, PricingService $pricing, string $metal='XAU'){
        $metal = strtoupper($metal);
        $q = Product::where('is_active',true)->where('metal',$metal);
        if ($r->filled('type')) $q->where('type',$r->type);
        if ($r->filled('brand')) $q->whereIn('brand',(array)$r->brand);
        if ($r->filled('min_g')) $q->where('weight_g','>=',(float)$r->min_g);
        if ($r->filled('max_g')) $q->where('weight_g','<=',(float)$r->max_g);
        $products = $q->orderBy('weight_g')->with('priceRule')->paginate(24);
        $products->getCollection()->transform(function($p) use($pricing){ $p->live_price=$pricing->priceFor($p); return $p; });
        return view('pages.catalog', compact('products','metal'));
    }
}
