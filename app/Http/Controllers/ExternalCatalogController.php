<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExternalProductsService;
use App\Services\PricingService;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\CartService;

class ExternalCatalogController extends Controller
{
     private function idsFromSlugs(array $slugs, array $list): array
    {
        if (empty($slugs)) return [];
        $map = [];
        foreach ($list as $row) {
            if (!empty($row['slug'])) $map[$row['slug']] = (int)$row['id'];
        }
        $ids = [];
        foreach ($slugs as $s) {
            $s = (string)$s;
            if (isset($map[$s])) $ids[] = $map[$s];
        }
        return array_values(array_unique($ids));
    }

    public function index(Request $r, ExternalProductsService $svc, PricingService $pricing)
    {
        $page = max(1, (int) $r->query('page', 1));
        $per  = max(1, (int) $r->query('per_page', 12));

        $categories = $svc->fetchCategories();
        $brands     = $svc->fetchBrands();
        $weights    = $svc->fetchWeightOptions();

        // Gather IDs (direct) and slugs
        $categoryIdsDirect = array_filter(array_map('intval', (array)$r->query('categories', [])));
        $brandIdsDirect    = array_filter(array_map('intval', (array)$r->query('brand', [])));
        $weightIdsDirect   = array_filter(array_map('intval', (array)$r->query('weight_option', [])));

        $categorySlugs = array_filter((array)$r->query('category_slug', []));
        $brandSlugs    = array_filter((array)$r->query('brand_slug', []));
        $weightSlugs   = array_filter((array)$r->query('weight_option_slug', []));

        // Translate slugs → ids, then merge with direct ids
        $categoryIds = array_values(array_unique(array_merge(
            $categoryIdsDirect,
            $this->idsFromSlugs($categorySlugs, $categories)
        )));
        $brandIds = array_values(array_unique(array_merge(
            $brandIdsDirect,
            $this->idsFromSlugs($brandSlugs, $brands)
        )));
        $weightIds = array_values(array_unique(array_merge(
            $weightIdsDirect,
            $this->idsFromSlugs($weightSlugs, $weights)
        )));

        $filters = [
            'search'         => trim((string) $r->query('search', '')) ?: null,
            'categories'     => $categoryIds,
            'brands'         => $brandIds,
            'weight_options' => $weightIds,
            'price_min'      => $r->filled('price_min') ? (float) $r->query('price_min') : null,
            'price_max'      => $r->filled('price_max') ? (float) $r->query('price_max') : null,
            'sort'           => $r->query('sort'),
        ];

        $data  = $svc->fetchList($page, $per, $filters);
        $total = (int) ($data['total'] ?? 0);

        $items = collect($data['products'] ?? [])
            ->map(fn ($ext) => $svc->mapForView($ext, $pricing))
            ->values();

        // (Optional fallback if API ignores weight filter)
        if (!empty($weightIds)) {
            $items = $items->filter(function ($row) use ($weightIds) {
                $woId = (int)($row['raw']['weight_option']['id'] ?? 0);
                return in_array($woId, $weightIds, true);
            })->values();
        }

        // Create paginator that generates /ext/catalog?page=2&... links
        $products = new LengthAwarePaginator(
            $items,
            $total,
            $per,
            $page,
            [
                'path'  => route('ext.catalog'),
                'query' => $r->query(), // keep other filters in links
            ]
        );

        return view('pages.external.catalog', compact('products', 'categories', 'brands','weights'));
    }
    public function show(string $slug, ExternalProductsService $svc, PricingService $pricing)
    {
        $ext = $svc->findBySlug($slug);
        abort_unless($ext, 404);

        $mapped = $svc->mapForView($ext, $pricing);
        $price  = $mapped['display_price']; // initial render

        return view('pages.external.product', [
            'p'     => $mapped,
            'price' => $price,
        ]);
    }

    // JSON live price for one external product id
    public function livePrice(int $id, Request $r, ExternalProductsService $svc, PricingService $pricing)
    {
        // fetch current page to find id (or refetch list 1 page; adjust if you add a /product?id= endpoint)
        $page = (int) $r->query('page', 1);
        $data = $svc->fetchList($page, 50);
        $ext = null;
        foreach (($data['products'] ?? []) as $prod) {
            if ((int)$prod['id'] === $id) { $ext = $prod; break; }
        }
        if (!$ext) return response()->json(['price_gbp'=>null], 404);

        $qty = (int) $r->query('qty', 1);
        $price = $svc->computeUnitPriceGBP($ext, $pricing, max(1, $qty));
        return response()->json(['price_gbp'=>$price]);
    }

    /**
     * Add-to-cart: upsert a local Product from the external item, then use existing Cart flow.
     */
    public function addToCart(Request $r, CartService $cartSvc)
    {
        $data = $r->validate([
            'external_id' => 'required|integer',
            'qty'         => 'nullable|integer|min:1',
        ]);

        $qty = max(1, (int)($data['qty'] ?? 1));

        // No local Product creation, no price rule writing.
        // Just remember the external product id in the cart:
        $cartSvc->addExternal((int)$data['external_id'], $qty);

        return redirect()->route('cart.index')->with('success', 'Added to cart');
    }
}
