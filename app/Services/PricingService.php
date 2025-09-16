<?php

namespace App\Services;

use App\Models\MetalQuote;
use App\Models\Product;
use App\Models\ProductPriceSnapshot;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PricingService
{
    public const TROY_OUNCE_IN_GRAMS = 31.1034768;

    /**
     * Get latest spot price per gram in GBP for a metal.
     * 1) Try external API (short-cache)
     * 2) Fallback to DB MetalQuote
     */
    public function latestSpotPerGramGBP(string $metal = 'XAU'): ?float
    {
        $metal = strtoupper($metal);
        $cacheKey = "spot_gbp_per_g:{$metal}";

        return Cache::remember($cacheKey, 20, function () use ($metal) {
            // --- 1) External API first ---
            $base   = rtrim((string) env('ISTOCK_API_BASE'), '/');      // e.g. http://localhost:8082/crm.istockandtax/api/v1
            $token  = (string) env('ISTOCK_API_TOKEN');                 // Bearer token expected by your API
            $path   = ltrim((string) env('ISTOCK_SPOT_ENDPOINT', 'spot_prices.php'), '/');
            $url    = "{$base}/{$path}";

            try {
                if ($base && $token) {
                    $resp = Http::timeout(10)
                        ->withHeaders(['Authorization' => "Bearer {$token}"])
                        ->get($url, [
                            'metal'    => $metal,   // your API can ignore or use this
                            'currency' => 'GBP',
                            'unit'     => 'gram',
                        ]);

                    if ($resp->ok()) {
                        $json = $resp->json();

                        // Accept several common shapes:
                        // 1) { per_gram: 60.123 }
                        if (is_array($json) && isset($json['per_gram']) && is_numeric($json['per_gram'])) {
                            return (float) $json['per_gram'];
                        }

                        // 2) { metal:'XAU', currency:'GBP', per_gram: 60.123 }
                        if (
                            is_array($json) &&
                            (isset($json['metal']) && strtoupper($json['metal']) === $metal) &&
                            (isset($json['currency']) && strtoupper($json['currency']) === 'GBP') &&
                            isset($json['per_gram']) && is_numeric($json['per_gram'])
                        ) {
                            return (float) $json['per_gram'];
                        }

                        // 3) { quotes: [{metal:'XAU', currency:'GBP', per_gram:60.1}, ...] }
                        if (is_array($json) && isset($json['quotes']) && is_array($json['quotes'])) {
                            foreach ($json['quotes'] as $q) {
                                if (
                                    isset($q['metal'], $q['currency'], $q['per_gram']) &&
                                    strtoupper((string)$q['metal']) === $metal &&
                                    strtoupper((string)$q['currency']) === 'GBP' &&
                                    is_numeric($q['per_gram'])
                                ) {
                                    return (float) $q['per_gram'];
                                }
                            }
                        }
                    } else {
                        Log::warning('Spot API non-OK', [
                            'status' => $resp->status(),
                            'url'    => $url,
                            'metal'  => $metal,
                            'body'   => $resp->body(),
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Spot API error', ['error' => $e->getMessage(), 'url' => $url ?? null, 'metal' => $metal]);
            }

            // --- 2) Fallback to DB ---
            $q = MetalQuote::where('metal', $metal)
                ->where('currency', 'GBP')
                ->orderByDesc('as_of')
                ->first();

            return $q ? (float) $q->per_gram : null;
        });
    }

    public function vatRateFor(Product $p): float
    {
        return $p->vat_exempt ? 0.0 : 0.20;
    }

    /**
     * Simple product price (sell) from spot + rule.
     * Kept as-is, now powered by live API spot above.
     */
    public function priceFor(Product $p, string $side = 'sell'): ?float
    {
        $spot = $this->latestSpotPerGramGBP($p->metal ?? 'XAU');
        if ($spot === null) return null;

        $rule        = $p->priceRule;
        $premiumPct  = $rule ? (float) $rule->premium_pct : 0.0;   // decimal, e.g. 0.05 for 5%
        $premiumFlat = $rule ? (float) $rule->premium_flat : 0.0;  // GBP flat

        $base  = $spot * (float) $p->weight_g;
        $gross = $base * (1 + $premiumPct) + $premiumFlat;

        $vatRate = $this->vatRateFor($p);
        if ($vatRate > 0) $gross *= (1 + $vatRate);

        return round($gross, 2);
    }

    public function snapshotAllActive(): int
    {
        $n = 0;
        Product::where('is_active', true)
            ->with('priceRule')
            ->chunk(200, function ($chunk) use (&$n) {
                foreach ($chunk as $p) {
                    $price = $this->priceFor($p);
                    if ($price !== null) {
                        ProductPriceSnapshot::create([
                            'product_id'      => $p->id,
                            'price_gbp'       => $price,
                            'spot_gbp_per_g'  => $this->latestSpotPerGramGBP($p->metal) ?? 0,
                            'as_of'           => now(),
                        ]);
                        $n++;
                    }
                }
            });
        return $n;
    }
}
