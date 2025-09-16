<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PricingService;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use \App\Services\ExternalProductsService;

class QuoteController extends Controller
{
    public function summary(Request $r, PricingService $pricing){
        $metal = strtoupper($r->query('metal','XAU'));
        return response()->json([
            'metal'=>$metal,
            'spot_gbp_per_g'=>$pricing->latestSpotPerGramGBP($metal),
            'as_of'=>now()->toIso8601String(),
        ]);
    }
    // public function productPrice(int $id, PricingService $pricing){
    //     $p = Product::with('priceRule')->findOrFail($id);
    //     return response()->json(['price_gbp'=>$pricing->priceFor($p)]);
    // }

public function productPrice(int $id, Request $request, PricingService $pricing, ExternalProductsService $calculate)
{
    // === 1) Resolve token (the external API expects PRODUCTS_API_KEY) ===
    $token = env('ISTOCK_API_TOKEN');
   
    if (!$token || $token === 'CHANGE_ME') {
        return response()->json([
            'error' => 'server_misconfigured',
            'hint'  => 'Set PRODUCTS_API_KEY in your Laravel .env to the SAME value the external API expects.',
        ], 500);
    }

    // === 2) Resolve base URL (must include /api/v1) ===
    $base = rtrim(env('ISTOCK_API_BASE'), '/');

    // === 3) Live spot prices ===
    $spotGold      = $pricing->latestSpotPerGramGBP('XAU');
    $spotSilver    = $pricing->latestSpotPerGramGBP('XAG');
    $spotPlatinum  = $pricing->latestSpotPerGramGBP('XPT');
    $spotPalladium = $pricing->latestSpotPerGramGBP('XPD');

    // === 4) Query to upstream: filter by product id and pass spots ===
    $q = [
        'domain_id'        => (int) env('ISTOCK_DOMAIN_ID'),
        'rental_user_id'   => (int) env('ISTOCK_RENTAL_USER_ID'),
        'front_status'     => (int) env('ISTOCK_FRONT_STATUS', 1),
        'front_stock_type' => (int) env('ISTOCK_FRONT_STOCK_TYPE', 1),
        'page'             => 1,
        'per_page'         => 1,
        'product_ids'      => $id, // make sure your external API added WHERE p.id IN (...)
    ];
    if ($spotGold      !== null) $q['spot_gold_gbp']      = $spotGold;
    if ($spotSilver    !== null) $q['spot_silver_gbp']    = $spotSilver;
    if ($spotPlatinum  !== null) $q['spot_platinum_gbp']  = $spotPlatinum;
    if ($spotPalladium !== null) $q['spot_palladium_gbp'] = $spotPalladium;

    // Optional: forward ?debug=1 to see upstream debug JSON
    if ($request->boolean('debug')) $q['debug'] = 1;

    $url  = $base.'/products.php';
    $resp = Http::timeout(12)
        ->withHeaders(['Authorization' => $token])
        ->get($url, $q);

    if (!$resp->ok()) {
        // Help yourself in logs / client when token/base is wrong
        $payload = $resp->json();
        return response()->json([
            'error'         => 'upstream_failed',
            'status'        => $resp->status(),
            'upstream_body' => $payload, // includes useful "debug" if you passed debug=1
            'hint'          => $resp->status() === 401
                ? 'Wrong/missing token. Ensure Laravel .env PRODUCTS_API_KEY matches external API.'
                : null,
        ], 502);
    }

    $data = $resp->json();
    $p    = $data['products'][0] ?? null;
    if (!$p) return response()->json(['error' => 'not_found'], 404);

    // Prefer upstream order_price, else price.final, else calc from spot
    // if (isset($p['order_price']) && is_numeric($p['order_price'])) {
    //     $price = (float) $p['order_price'];
    // } elseif (isset($p['price']['final']) && is_numeric($p['price']['final'])) {
    //     $price = (float) $p['price']['final'];
    // } else {
        $metalName = strtolower($p['front_metal']['name'] ?? 'gold');
        $spot = $spotGold;
        if (strpos($metalName, 'silver')   !== false) $spot = $spotSilver;
        if (strpos($metalName, 'platinum') !== false) $spot = $spotPlatinum;
        if (strpos($metalName, 'palladium')!== false) $spot = $spotPalladium;

        $qty   = max(1, (int)$request->input('qty', 1));
        $price = $calculate->computeUnitPriceGBP($p, $pricing, $qty);

      //  }
        
        return response()->json(['price_gbp' => round((float)$price, 2)]);
    }

    private function calcFromSpot(
        float $spot_per_gram,
        float $weight_g,
        float $fineness,
        float $premium_percent,
        float $premium_flat,
        float $making_charge,
        float $margin_percent,
        float $vat_rate
    ): float {
        $purity = max(0.0, $fineness) / 1000.0;
        $melt = $weight_g * $purity * $spot_per_gram;
        $premium_value = ($melt * ($premium_percent/100.0)) + $premium_flat;
        $subtotal = $melt + $premium_value + $making_charge;
        $with_margin = $subtotal * (1 + $margin_percent/100.0);
        $final = $with_margin * (1 + $vat_rate/100.0);
        return round($final, 2);
    }

}
