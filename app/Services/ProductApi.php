<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProductApi
{
    /*** EXISTING HELPERS (kept) ***/
    private function base(): string { return rtrim(env('ISTOCK_API_BASE'), '/'); }
    private function path(): string { return ltrim(env('ISTOCK_API_PRODUCTS_PATH', 'products.php'), '/'); }
    private function auth(): string { return env('ISTOCK_API_TOKEN'); }
    private function timeout(): int { return (int) env('PRODUCT_API_TIMEOUT', 12); }

    private function headers(): array
    {
        return [
            'Authorization' => $this->auth(),       // your API expects this exact header
            'Accept'        => 'application/json',
        ];
    }

    /**
     * Latest arrivals (homepage tiles etc.)
     * - Uses same conventions as fetchList()
     * - Sorts by front_add_date DESC (newest first)
     * - Optionally pass $frontStockType (1 bullion, 2 preowned, 3 diamond). If null, omit to get mixed.
     */
    public function latestArrivals(int $limit = 7, ?int $frontStockType = null): array
    {
        // Decide stock type from URL segment (same rule you used), but for homepage we’ll keep it mixed by default.
        $segment = request()->segment(1); // e.g. 'preowned' when /preowned/...
        if ($frontStockType === null) {
            if ($segment === 'buillion') {
                $frontStockType = 1;
            } elseif ($segment === 'preowned') {
                $frontStockType = 2;
            } elseif ($segment === 'diamond') {
                $frontStockType = 3;
            }
        }

        $q = [
            'domain_id'      => env('ISTOCK_DOMAIN_ID'),
            'rental_user_id' => env('ISTOCK_RENTAL_USER_ID'),
            'page'           => 1,
            'per_page'       => max(1, min(60, $limit)),
            'front_status'   => env('ISTOCK_FRONT_STATUS', 1),
            'sort'           => 'front_add_date',
            'direction'      => 'DESC',
        ];

        if (!empty($frontStockType)) {
            $q['front_stock_type'] = (int) $frontStockType;
        }

        // Attach live spot prices (GBP/gram) – safe to skip on failure
        try {
            /** @var \App\Services\PricingService $pricing */
            $pricing = app(\App\Services\PricingService::class);
            $spotMap = [
                'spot_gold_gbp'      => 'XAU',
                'spot_silver_gbp'    => 'XAG',
                'spot_platinum_gbp'  => 'XPT',
                'spot_palladium_gbp' => 'XPD',
            ];
            foreach ($spotMap as $param => $metal) {
                $val = $pricing->latestSpotPerGramGBP($metal);
                if ($val !== null && is_numeric($val)) {
                    $q[$param] = round((float)$val, 6);
                }
            }
        } catch (\Throwable $e) {
            // ignore – API can fall back to cached price
        }

        // Cache key includes query (spots too) so newest + pricing stay consistent
        $cacheKey = 'latest_arrivals:v2:' . md5(json_encode($q));

        //return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($q) {
            $url = $this->base() . '/' . $this->path();

            try {
                $resp = Http::timeout($this->timeout())
                    ->withHeaders($this->headers())
                    ->get($url, $q);

                if ($resp->failed()) {
                    return [
                        'data' => [],
                        'meta' => ['page'=>1,'per_page'=>$q['per_page'],'total'=>0,'last_page'=>1],
                        'error'=> ['status'=>$resp->status(),'body'=>$resp->json() ?? $resp->body()],
                    ];
                }

                $json = $resp->json();

                $pricing = app(\App\Services\PricingService::class);
                $svc     = app(\App\Services\ExternalProductsService::class);

                $rawProducts = $json['products'] ?? $json['data'] ?? [];

                // Map RAW → view model (adds display_price via computeUnitPriceGBP)
                $items = array_map(
                    fn(array $p) => $svc->mapForView($p, $pricing),
                    $rawProducts
                );
                
                // Normalize fields coming from your ISTOCK API
                // $items = array_map(function ($p) {
                //     // Image resolution priority
                //     $image = $p['image'] ?? $p['main_image'] ?? $p['image_url'] ?? null;
                //     if (!$image && !empty($p['images']) && is_array($p['images'])) {
                //         $image = $p['images'][0] ?? null;
                //     }

                //     // In-stock logic: prefer explicit, else quantity > 0
                //     $inStock = null;
                //     if (array_key_exists('in_stock', $p)) {
                //         $inStock = (bool) $p['in_stock'];
                //     } elseif (array_key_exists('stock_status', $p)) {
                //         $inStock = in_array(strtolower((string)$p['stock_status']), ['in', 'instock', 'available', '1', 'yes'], true);
                //     } elseif (array_key_exists('quantity', $p)) {
                //         $inStock = (int)$p['quantity'] > 0;
                //     }

                //     return [
                //         'id'         => $p['id'] ?? $p['product_id'] ?? null,
                //         'name'       => $p['front_title'] ?? $p['title'] ?? $p['name'] ?? '-',
                //         'sku'        => $p['sku'] ?? null,
                //         'price'      => $p['price_cached'] ?? $p['price'] ?? null,
                //         'currency'   => $p['currency'] ?? 'GBP',
                //         'image'      => $image,
                //         'created_at' => $p['front_add_date'] ?? $p['created_at'] ?? null,
                //         'in_stock'   => $inStock,
                //         // If API gives a slug or URL, pass it through so your Blade can link out
                //         'url'        => $p['url'] ?? null,
                //         'slug'       => $p['front_slug'] ?? null,
                //     ];
                // }, $json['products'] ?? ($json['products'] ?? []));

                // Meta fallbacks
                $meta = [
                    'page'      => (int) (data_get($json, 'meta.page', 1) ?: data_get($json, 'page.current', 1)),
                    'per_page'  => (int) (data_get($json, 'meta.per_page', count($items)) ?: data_get($json, 'page.per_page', count($items))),
                    'total'     => (int) (data_get($json, 'meta.total', count($items)) ?: data_get($json, 'page.total', count($items))),
                    'last_page' => (int) (data_get($json, 'meta.last_page', 1) ?: data_get($json, 'page.last', 1)),
                ];

                return ['data' => $items, 'meta' => $meta];
            } catch (ConnectionException $e) {
                return [
                    'data' => [],
                    'meta' => ['page'=>1,'per_page'=>$q['per_page'],'total'=>0,'last_page'=>1],
                    'error'=> ['status'=>'connection_error','body'=>$e->getMessage()],
                ];
            } catch (\Throwable $e) {
                return [
                    'data' => [],
                    'meta' => ['page'=>1,'per_page'=>$q['per_page'],'total'=>0,'last_page'=>1],
                    'error'=> ['status'=>'unexpected_error','body'=>$e->getMessage()],
                ];
            }
       // });
    }   

    public function trending(int $limit = 12, ?int $frontStockType = null, string $window = '7d'): array
{
    // Infer stock type from URL segment (same logic as latestArrivals)
    $segment = request()->segment(1);
    if ($frontStockType === null) {
        if ($segment === 'buillion')       $frontStockType = 1;
        elseif ($segment === 'preowned')   $frontStockType = 2;
        elseif ($segment === 'diamond')    $frontStockType = 3;
    }

    // Allow env override for upstream sorting/params
    $sortField   = env('ISTOCK_TRENDING_SORT', 'trending_score'); // try what your API supports
    $sortDir     = env('ISTOCK_TRENDING_DIR', 'DESC');
    $windowParam = env('ISTOCK_TRENDING_WINDOW_PARAM', 'window'); // e.g. '7d'/'30d'
    $flagParam   = env('ISTOCK_TRENDING_FLAG_PARAM', 'trending'); // some APIs want trending=1

    $q = [
        'domain_id'      => env('ISTOCK_DOMAIN_ID'),
        'rental_user_id' => env('ISTOCK_RENTAL_USER_ID'),
        'page'           => 1,
        'per_page'       => max(1, min(60, $limit)),
        'front_status'   => env('ISTOCK_FRONT_STATUS', 1),
        'sort'           => $sortField,     // upstream try
        'direction'      => $sortDir,
        $windowParam     => $window,        // e.g. 7d/30d
        $flagParam       => 1,              // hint upstream we want trending
    ];

    if (!empty($frontStockType)) {
        $q['front_stock_type'] = (int)$frontStockType;
    }

    // Attach live spot prices (GBP/gram) – safe if it fails
    try {
        /** @var \App\Services\PricingService $pricing */
        $pricing = app(\App\Services\PricingService::class);
        $spotMap = [
            'spot_gold_gbp'      => 'XAU',
            'spot_silver_gbp'    => 'XAG',
            'spot_platinum_gbp'  => 'XPT',
            'spot_palladium_gbp' => 'XPD',
        ];
        foreach ($spotMap as $param => $metal) {
            $val = $pricing->latestSpotPerGramGBP($metal);
            if ($val !== null && is_numeric($val)) {
                $q[$param] = round((float)$val, 6);
            }
        }
    } catch (\Throwable $e) {
        // ignore – upstream may use its own cache
    }

    $url = $this->base() . '/' . $this->path();

    try {
        $resp = Http::timeout($this->timeout())
            ->withHeaders($this->headers())
            ->get($url, $q);

        if ($resp->failed()) {
            return [
                'data' => [],
                'meta' => ['page'=>1,'per_page'=>$q['per_page'],'total'=>0,'last_page'=>1],
                'error'=> ['status'=>$resp->status(),'body'=>$resp->json() ?? $resp->body()],
            ];
        }

        $json       = $resp->json();
        $raw        = $json['products'] ?? $json['data'] ?? [];
        $totalRaw   = is_countable($raw) ? count($raw) : 0;

        // If upstream didn’t really give us trending order, compute a local score.
        // We’ll look for common fields and weigh them. Adjust weights as you like.
        $scoreFn = function(array $p) use ($window): float {
            $v7  = (float)($p['views_7d']   ?? 0);
            $o7  = (float)($p['orders_7d']  ?? 0);
            $c7  = (float)($p['clicks_7d']  ?? 0);
            $v30 = (float)($p['views_30d']  ?? 0);
            $o30 = (float)($p['orders_30d'] ?? 0);

            // If the API already sends a score, use it
            if (isset($p['trending_score']) && is_numeric($p['trending_score'])) {
                return (float)$p['trending_score'];
            }

            // Basic weighted heuristic
            $score7  = ($v7 * 0.8) + ($c7 * 1.0) + ($o7 * 4.0);
            $score30 = ($v30 * 0.2) + ($o30 * 1.5);

            // Gentle recency bonus (newer -> slightly higher)
            $tsStr = $p['front_add_date'] ?? $p['created_at'] ?? null;
            $recencyBonus = 0.0;
            if ($tsStr) {
                try {
                    $ts = strtotime($tsStr) ?: 0;
                    $ageDays = max(1, (time() - $ts) / 86400);
                    $recencyBonus = 10.0 / $ageDays; // decays over time
                } catch (\Throwable $e) {}
            }

            return $score7 + $score30 + $recencyBonus;
        };

        // If upstream didn’t deliver already-sorted data by our desired field,
        // sort locally by the computed score.
        $sorted = $raw;
        // Detect whether upstream likely sorted by our field; if not, sort locally.
        $shouldSortLocally = true;
        if (!empty($raw) && isset($raw[0]) && is_array($raw[0])) {
            // Heuristic: if first item has a higher/equal score than median, assume sorted.
            try {
                $scores = array_map($scoreFn, $raw);
                $first  = $scores[0] ?? 0;
                $tmp    = $scores;
                sort($tmp);
                $median = $tmp[(int)floor(count($tmp)/2)] ?? 0;
                $shouldSortLocally = $first < $median; // if first < median, it's probably not trending-sorted
            } catch (\Throwable $e) {
                $shouldSortLocally = true;
            }
        }

        if ($shouldSortLocally) {
            usort($sorted, function($a, $b) use ($scoreFn) {
                $sa = $scoreFn($a);
                $sb = $scoreFn($b);
                if ($sa === $sb) return 0;
                return ($sa > $sb) ? -1 : 1; // DESC
            });
        }

        // Trim to requested limit after sort
        if (count($sorted) > $limit) {
            $sorted = array_slice($sorted, 0, $limit);
        }

        // Map RAW → view model (adds display_price via computeUnitPriceGBP)
        $pricing = app(\App\Services\PricingService::class);
        $svc     = app(\App\Services\ExternalProductsService::class);

        $items = array_map(
            fn(array $p) => $svc->mapForView($p, $pricing),
            $sorted
        );

        // Meta
        $meta = [
            'page'      => 1,
            'per_page'  => (int)$q['per_page'],
            'total'     => (int)$totalRaw,
            'last_page' => 1,
        ];

        return ['data' => $items, 'meta' => $meta];
    } catch (ConnectionException $e) {
        return [
            'data' => [],
            'meta' => ['page'=>1,'per_page'=>$q['per_page'],'total'=>0,'last_page'=>1],
            'error'=> ['status'=>'connection_error','body'=>$e->getMessage()],
        ];
    } catch (\Throwable $e) {
        return [
            'data' => [],
            'meta' => ['page'=>1,'per_page'=>$q['per_page'],'total'=>0,'last_page'=>1],
            'error'=> ['status'=>'unexpected_error','body'=>$e->getMessage()],
        ];
    }
}


    /*** Your existing fetchList(...) stays here unchanged ***/
}
