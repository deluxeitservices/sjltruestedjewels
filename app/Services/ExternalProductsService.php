<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ExternalProductsService
{
    private function base(): string { return rtrim(env('ISTOCK_API_BASE'), '/'); }
    private function path(): string { return ltrim(env('ISTOCK_API_PRODUCTS_PATH', 'products.php'), '/'); }
    private function auth(): string { return env('ISTOCK_API_TOKEN'); }

    private function headers(): array
    {
        return [
            'Authorization' => $this->auth(),
            'Accept'        => 'application/json',
        ];
    }

    public function fetchList(int $page = 1, int $perPage = 50, array $filters = []): array
    {
        $request = request();
        $segment = $request->segment(1); // Returns 'preowned' if URL is /preowned


        $front_stock_type = 1;
        if($segment == 'buillion'){
            $front_stock_type = 1;
        }else if($segment == 'preowned'){
            $front_stock_type = 2;
        }else if($segment == 'diamond'){
            $front_stock_type = 3;
        }
        $q = [
            'domain_id'        => env('ISTOCK_DOMAIN_ID'),
            'rental_user_id'   => env('ISTOCK_RENTAL_USER_ID'),
            'page'             => $page,
            'per_page'         => $perPage,
            'front_status'     => env('ISTOCK_FRONT_STATUS', 1),
            // 'front_stock_type' => env('ISTOCK_FRONT_STOCK_TYPE', 1),
            'front_stock_type' => $front_stock_type,
        ];

        // preowned - 2 
        // buillion = 1
        // diammond - 3 

        // --- Always send live spot prices (GBP/gram) ---
        try {
            /** @var \App\Services\PricingService $pricing */
            $pricing = app(\App\Services\PricingService::class);

            // Map API param => metal code used by your PricingService
            $spotMap = [
                'spot_gold_gbp'      => 'XAU',
                'spot_silver_gbp'    => 'XAG',
                'spot_platinum_gbp'  => 'XPT',
                'spot_palladium_gbp' => 'XPD',
            ];

            foreach ($spotMap as $param => $metalCode) {
                $val = $pricing->latestSpotPerGramGBP($metalCode);
                if ($val !== null && is_numeric($val)) {
                    // keep a stable precision (DB/math safe)
                    $q[$param] = round((float)$val, 6);
                }
            }
        } catch (\Throwable $e) {
            // If PricingService isn't available, don't block the request.
            // API will fall back to multibuy/price_cached.
        }

        // --- Search ---
        if (!empty($filters['search'])) {
            $q['search'] = $filters['search'];
            $q['q']      = $filters['search']; // API accepts either
        }

        // --- Category (IDs or slugs) ---
        if (!empty($filters['categories'])) {
            $q['category_ids'] = implode(',', array_map('intval', (array) $filters['categories']));
        }
        if (!empty($filters['category_slug'])) {
            $q['category_slug'] = array_values(array_map('strval', (array) $filters['category_slug']));
        }

        // --- Brand (IDs or slugs) ---
        if (!empty($filters['brands'])) {
            $q['brand_ids'] = implode(',', array_map('intval', (array) $filters['brands']));
        }
        if (!empty($filters['brand_slug'])) {
            $q['brand_slug'] = array_values(array_map('strval', (array) $filters['brand_slug']));
        }

        // --- Weight options (IDs or slugs) ---
        if (!empty($filters['weight_options'])) {
            $q['weight_option_ids'] = implode(',', array_map('intval', (array) $filters['weight_options']));
        }
        if (!empty($filters['weight_option_slug'])) {
            $q['weight_option_slug'] = array_values(array_map('strval', (array) $filters['weight_option_slug']));
        }

        // --- Optional price range passthrough (if your API supports it) ---
        if (isset($filters['price_min']) && $filters['price_min'] !== '') {
            $q['price_min'] = (float) $filters['price_min'];
        }
        if (isset($filters['price_max']) && $filters['price_max'] !== '') {
            $q['price_max'] = (float) $filters['price_max'];
        }

       
        // --- Sort mapping (UI -> API) ---
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price-asc':
                    $q['sort']      = 'price_cached';
                    $q['direction'] = 'ASC';
                    break;
                case 'price-desc':
                    $q['sort']      = 'price_cached';
                    $q['direction'] = 'DESC';
                    break;
                case 'newest':
                    $q['sort']      = 'front_add_date';
                    $q['direction'] = 'DESC';
                    break;
                case 'sku-asc':
                    $q['sort']      = 'sku';
                    $q['direction'] = 'ASC';
                    break;
                case 'sku-desc':
                    $q['sort']      = 'sku';
                    $q['direction'] = 'DESC';
                    break;
                case 'title-asc':
                    $q['sort']      = 'front_title';
                    $q['direction'] = 'ASC';
                    break;
                case 'title-desc':
                    $q['sort']      = 'front_title';
                    $q['direction'] = 'DESC';
                    break;
                default:
                    // Leave API defaults (your API now defaults to price ASC)
                    break;
            }
        }
        // Optional explicit overrides
        if (!empty($filters['direction'])) {
            $q['direction'] = strtoupper($filters['direction']) === 'ASC' ? 'ASC' : 'DESC';
        }
        if (!empty($filters['api_sort'])) {
            $q['sort'] = $filters['api_sort'];
        }
        if (!empty($filters['product_slug'])) {
            $q['product_slug'] = $filters['product_slug'];
        }
        // --- Cache & request ---
        // Include spots in cache key so live price changes don’t serve stale sort orders.
        $cacheKey = 'ext_products:' . md5(json_encode($q));
        return \Cache::remember($cacheKey, 15, function () use ($q) {
            $url  = $this->base() . '/' . $this->path();
            $resp = \Http::timeout(12)->withHeaders($this->headers())->get($url, $q);
            $resp->throw();
            return $resp->json();
        });
    }


    /** Fetch categories for filters */
    public function fetchCategories(int $page = 1, int $per = 100): array
    {
        $q = [
            'domain_id'        => env('ISTOCK_DOMAIN_ID'),
            'rental_user_id'   => env('ISTOCK_RENTAL_USER_ID'),
            'page'             => $page,
            'per_page'         => $per,
            'front_status'     => env('ISTOCK_FRONT_STATUS', 1),
            'front_stock_type' => env('ISTOCK_FRONT_STOCK_TYPE', 1),
        ];
        $key = 'ext_categories:'.md5(json_encode($q));
        return Cache::remember($key, 300, function () use ($q) {
            $url = $this->base().'/categories.php';
            $resp = Http::timeout(12)->withHeaders($this->headers())->get($url, $q);
            $resp->throw();
            $j = $resp->json();
            $list = [];
            foreach (($j['categories'] ?? $j['data'] ?? []) as $row) {
                $name = (string)($row['name'] ?? '');
                $list[] = [
                    'id'    => (int)   ($row['id'] ?? 0),
                    'name'  => $name,
                    'slug'  => (string)($row['slug'] ?? Str::slug($name)), // <-- slug
                    'count' => (int)   ($row['count'] ?? $row['products_count'] ?? 0),
                ];
            }
            return $list;
        });
    }

    public function fetchBrands(int $page = 1, int $per = 100): array
    {
        $q = [
            'domain_id'        => env('ISTOCK_DOMAIN_ID'),
            'rental_user_id'   => env('ISTOCK_RENTAL_USER_ID'),
            'page'             => $page,
            'per_page'         => $per,
            'front_status'     => env('ISTOCK_FRONT_STATUS', 1),
            'front_stock_type' => env('ISTOCK_FRONT_STOCK_TYPE', 3),
        ];
        $key = 'ext_brands:'.md5(json_encode($q));
        return Cache::remember($key, 300, function () use ($q) {
            $url = $this->base().'/front_brand_list.php';
            $resp = Http::timeout(12)->withHeaders($this->headers())->get($url, $q);
            $resp->throw();
            $j = $resp->json();
            $list = [];
            foreach (($j['brands'] ?? $j['data'] ?? []) as $row) {
                $name = (string)($row['name'] ?? '');
                $list[] = [
                    'id'    => (int)   ($row['id'] ?? 0),
                    'name'  => $name,
                    'slug'  => (string)($row['slug'] ?? Str::slug($name)), // <-- slug
                    'count' => (int)   ($row['count'] ?? $row['products_count'] ?? 0),
                ];
            }
            return $list;
        });
    }

    public function fetchWeightOptions(int $page = 1, int $per = 100): array
    {
        $q = [
            'domain_id'        => env('ISTOCK_DOMAIN_ID'),
            'rental_user_id'   => env('ISTOCK_RENTAL_USER_ID'),
            'page'             => $page,
            'per_page'         => $per,
            'front_status'     => env('ISTOCK_FRONT_STATUS', 1),
            'front_stock_type' => env('ISTOCK_FRONT_STOCK_TYPE', 3),
        ];
        $key = 'ext_weight_options:'.md5(json_encode($q));
        return Cache::remember($key, 300, function () use ($q) {
            $url = $this->base().'/front_weight_options_list.php';
            $resp = Http::timeout(12)->withHeaders($this->headers())->get($url, $q);
            $resp->throw();
            $j = $resp->json();
            $list = [];
            foreach (($j['weight_options'] ?? $j['data'] ?? []) as $row) {
                $label = (string)($row['label'] ?? '');
                $fallback = $label ?: ((string)($row['grams_exact'] ?? ''));
                $list[] = [
                    'id'          => (int)   ($row['id'] ?? 0),
                    'grams_exact' => (float) ($row['grams_exact'] ?? 0),
                    'label'       => $label,
                    'slug'        => (string)($row['slug'] ?? Str::slug($fallback)), // <-- slug
                    'count'       => (int)   ($row['count'] ?? $row['products_count'] ?? 0),
                ];
            }
            return $list;
        });
    }
    public function findBySlug(string $slug): ?array
    {
        // ask the API to return this product directly; 1 per page is fine
        $data = $this->fetchList(1, 1, ['product_slug' => $slug]);
        return isset($data['products'][0]) ? $data['products'][0] : null;
    }
    // public function findBySlug(string $slug): ?array
    // {
    //     // Basic approach: scan the first few pages until found (adjust as needed)
    //     for ($p = 1; $p <= 3; $p++) {
    //         $data = $this->fetchList($p, 50);
    //         foreach (($data['products'] ?? []) as $prod) {
    //             if (($prod['front_slug'] ?? '') === $slug) {
    //                 return $prod;
    //             }
    //         }
    //     }
    //     return null;
    // }

    public static function metalToCode(?string $name): string
    {
        $n = strtolower((string)$name);
        return match ($n) {
            'gold'      => 'XAU',
            'silver'    => 'XAG',
            'platinum'  => 'XPT',
            'palladium' => 'XPD',
            default     => 'XAU',
        };
    }

    /**
     * Compute unit price (GBP) from:
     * spot(gbp/g) * weight_g  -> base
     * + premium% + margin%    -> percentage premiums
     * + making_charge (flat GBP per unit)
     * + VAT (vat_rate%)
     *
     * Multibuy (optional): if qty >= threshold apply discount percent off final pre-VAT or post-VAT?
     * Here: apply the multibuy % off the net (pre-VAT) + then VAT.
     */
    public function computeUnitPriceGBP(array $extProduct, \App\Services\PricingService $pricing, int $qty = 1): ?float
    {
        // --- Spot & melt ---
        $metalName = $extProduct['front_metal']['name'] ?? 'Gold';
        $metalCode = self::metalToCode($metalName);
        $spot      = $pricing->latestSpotPerGramGBP($metalCode);
        if ($spot === null) return null;

        $weightG   = (float)($extProduct['weight_g'] ?? 0);
        $fineness  = (float)($extProduct['front_fineness'] ?? 999.9);
        $purity    = $fineness / 1000.0;

        // melt = weight * purity * spot
        $melt = $weightG * $purity * $spot;

        // --- Base charges (as decimal rates) ---
        $basePremiumPct = (float)($extProduct['premium_percent'] ?? 0) / 100.0; // qty=1 premium %
        $marginPct      = (float)($extProduct['margin_percent']  ?? 0) / 100.0;
        $makingFlat     = (float)($extProduct['making_charge']   ?? 0);         // GBP per unit
        $vatRate        = (float)($extProduct['vat_rate']        ?? 0) / 100.0;

        // Optional product-level flat premium if you add it later (kept for completeness)
        $productPremiumFlat = isset($extProduct['premium_flat']) ? (float)$extProduct['premium_flat'] : 0.0;

        // --- Pick premium for the requested qty ---
        // We interpret multibuy tiers as *premium definitions* for that qty:
        // - type "percent":   use this percent as the premium %
        // - type "flat":      use this as a *flat premium* (GBP) in addition to percent (if you want only-flat, set percent=0)
        $effectivePremiumPct  = $basePremiumPct;   // default percent (qty=1)
        $effectivePremiumFlat = $productPremiumFlat; // default flat

        if (!empty($extProduct['multibuy']) && is_array($extProduct['multibuy'])) {
            $bestTier = null;
            foreach ($extProduct['multibuy'] as $tier) {
                $min = (int)($tier['qty_min'] ?? 0);
                if ($qty >= $min) {
                    if ($bestTier === null || $min > (int)($bestTier['qty_min'] ?? 0)) {
                        $bestTier = $tier;
                    }
                }
            }
            if ($bestTier) {
                $type = strtolower((string)($bestTier['type'] ?? ''));

                if (isset($bestTier['percent']) && is_numeric($bestTier['percent'])) {
                    $effectivePremiumPct = ((float)$bestTier['percent']) / 100.0;
                }

                if ($type === 'flat' && isset($bestTier['flat']) && is_numeric($bestTier['flat'])) {
                    $effectivePremiumFlat = (float)$bestTier['flat'];
                }
                // NOTE: We intentionally ignore any 'each_price' in tier to always use your formula.
            }
        }

        // --- Apply formula exactly as requested ---
        // premium_value = (melt * premium%) + premium_flat
        $premiumValue = ($melt * $effectivePremiumPct) + $effectivePremiumFlat;

        // subtotal = melt + premium_value + making_charge
        $subtotal = $melt + $premiumValue + $makingFlat;

        // with_margin = subtotal * (1 + margin%)
        $withMargin = $subtotal * (1 + $marginPct);

        // final = with_margin * (1 + VAT%)
        $finalUnit = $withMargin * (1 + $vatRate);
        $grosprice = $finalUnit * $qty;
        // return UNIT price (caller can multiply by $qty for totals)
        return round(max(0.0, $grosprice), 2);
    }




    public function mapForView(array $ext, \App\Services\PricingService $pricing): array
    {
        $metalName = $ext['front_metal']['name'] ?? 'Gold';
        $metalCode = self::metalToCode($metalName);

        return [
            'external_id'   => $ext['id'],
            'slug'          => $ext['front_slug'],
            'title'         => $ext['front_title'],
            'sku'           => $ext['sku'] ?? null,               // <-- add this
            'brand'         => $ext['brand']['name'] ?? null,
            'metal'         => $metalCode,
            'fineness'      => $ext['front_fineness'] ?? null,
            'weight_g'      => $ext['weight_g'] ?? null,
            'status'        => $ext['status'] ?? null,
            'availability'  => $ext['availability'] ?? null,
            'long_desc'     => $ext['long_desc'] ?? null,
            'front_metal'     => $ext['front_metal'] ?? null,
            'image'         => $ext['primary_image']['url'] ?? ($ext['primary_image']['url'] ?? null),
            'multiimages'         => $ext['images'] ?? ($ext['images'] ?? null),
            'raw'           => $ext,
            'display_price' => $this->computeUnitPriceGBP($ext, $pricing, 1),
        ];
    }

    public function fetchByExternalId(int $id): ?array
    {
        // Prefer server API filter if available
        $q = [
            'domain_id'        => env('ISTOCK_DOMAIN_ID'),
            'rental_user_id'   => env('ISTOCK_RENTAL_USER_ID'),
            'front_status'     => env('ISTOCK_FRONT_STATUS', 1),
            'front_stock_type' => env('ISTOCK_FRONT_STOCK_TYPE', 1),
            'product_ids'      => $id,
            'page'             => 1,
            'per_page'         => 1,
        ];

        $url  = $this->base().'/'.$this->path();
        $resp = \Http::timeout(10)->withHeaders($this->headers())->get($url, $q);
        if ($resp->ok()) {
            $j = $resp->json();
            if (!empty($j['products'][0])) return $j['products'][0];
        }

        // Fallback: scan first page or two if your API doesn't support product_ids
        $list = $this->fetchList(1, 100);
        foreach (($list['products'] ?? []) as $p) {
            if ((int)$p['id'] === $id) return $p;
        }
        return null;
    }
    public function fetchByIds(array $ids, \App\Services\PricingService $pricing): array
    {
        
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
        if (empty($ids)) return [];

        // Live spot to pass upstream (so order_price is computed server-side if you support it)
        $q = [
            'domain_id'        => (int) env('ISTOCK_DOMAIN_ID'),
            'rental_user_id'   => (int) env('ISTOCK_RENTAL_USER_ID'),
            'front_status'     => (int) env('ISTOCK_FRONT_STATUS', 1),
            // 'front_stock_type' => (int) env('ISTOCK_FRONT_STOCK_TYPE', 1),
            'product_ids'      => implode(',', $ids),
            'page'             => 1,
            'per_page'         => max(50, count($ids)),
        ];


        // Add live spots (if available)
        $spotGold      = $pricing->latestSpotPerGramGBP('XAU');
        $spotSilver    = $pricing->latestSpotPerGramGBP('XAG');
        $spotPlatinum  = $pricing->latestSpotPerGramGBP('XPT');
        $spotPalladium = $pricing->latestSpotPerGramGBP('XPD');
        if ($spotGold      !== null) $q['spot_gold_gbp']      = $spotGold;
        if ($spotSilver    !== null) $q['spot_silver_gbp']    = $spotSilver;
        if ($spotPlatinum  !== null) $q['spot_platinum_gbp']  = $spotPlatinum;
        if ($spotPalladium !== null) $q['spot_palladium_gbp'] = $spotPalladium;

        $cacheKey = 'ext_products_by_ids:'.md5(json_encode($q));
        $res = \Cache::remember($cacheKey, 20, function () use ($q) {
            $url  = rtrim($this->base(), '/').'/'.$this->path(); // e.g. .../api/v1/products.php
            $resp = \Http::timeout(12)->withHeaders($this->headers())->get($url, $q);
            $resp->throw();
           
            return $resp->json();
        });

        $map = [];
        foreach (($res['products'] ?? []) as $p) {
            if (!empty($p['id'])) $map[(int)$p['id']] = $p;
        }
        return $map; // [external_id => extProduct array]
    }
}
