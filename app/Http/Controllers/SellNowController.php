<?php

namespace App\Http\Controllers;

use App\Models\JewelleryTabMaster;
use App\Models\SellItem;
use App\Services\ExternalProductsService;
use App\Models\User;
use App\Services\PricingService; // <— use live pricing service
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; // <-- ADD THIS

class SellNowController extends Controller
{
    public function __construct(private PricingService $pricing) {}
    private const UI_TO_ISO = [
        'gold'      => 'XAU',
        'silver'    => 'XAG',
        'platinum'  => 'XPT',
        'palladium' => 'XPD',
    ];
    public function index(ExternalProductsService $svc)
    {
        // Pull Item presets from external API (cached by the service)
        $weights = $svc->fetchWeightOptions(page: 1, per: 200);

        // Map API rows to front-end preset structure
        $items = collect($weights)->map(function ($w) {
            $grams = (float)($w['grams_exact'] ?? 0);
            $label = trim((string)($w['label'] ?? ''));
            $fallbackLabel = $grams > 0
                ? rtrim(rtrim(number_format($grams, 3, '.', ''), '0'), '.') . 'g'
                : 'Custom Weight';

            return [
                'id'     => (int)($w['id'] ?? 0),
                'slug'   => (string)($w['slug'] ?? ''),
                'label'  => $label !== '' ? $label : $fallbackLabel,
                'metal'  => strtolower($w['metal'] ?? 'gold'),
                'weight' => $grams,
                'purity' => '24ct (99.99%)',
            ];
        })->filter(fn ($x) => $x['weight'] > 0)->values()->all();

        // Fallback purity list (used until the user chooses)
        $purities = [
            '24ct (99.99%)','23ct (95.80%)','22ct (91.6%)','21ct (87.5%)','20ct (83.3%)',
            '18ct (75%)','14ct (58.5%)','9ct (37.5%)','999.5 (99.95%)','999 (99.9%)',
            '950 (95%)','925 (92.5%)'
        ];
        $metals   = ['gold','silver','platinum','palladium'];

        return view('sell-now.index', compact('items','purities','metals'));
    }

    /**
     * AJAX calculator: spot(£/g) × purity × weight × qty × buyRate%
     * Uses live per-gram from PricingService (table/API) and optional buy-rate config.
     */
    public function calc(Request $request)
    {
        $data = $request->validate([
            'item_key'     => ['nullable','string','max:64'], // e.g. gold_jewellery, silver_bar (optional)
            'metal'        => ['required', Rule::in(['gold','silver','platinum','palladium'])],
            'purity_label' => ['required','string','max:50'],
            'qty'          => ['required','integer','min:1','max:9999'],
            'weight_g'     => ['required','numeric','min:0.001','max:100000'],
        ]);

        $purity     = $this->purityFromLabel($data['purity_label']);
        $perGram    = $this->livePerGram($data['metal']);            // live £/g from PricingService
        $buyRate    = $this->buyRate($data['item_key'] ?? null, $data['metal']); // 0.85, 0.98, etc.
        $unit       = $perGram * $purity * (float)$data['weight_g'] * $buyRate;
        $line       = $unit * (int)$data['qty'];

        return response()->json([
            'unit_price' => round($unit, 2),
            'line_total' => round($line, 2),
            'pure_p_g'   => round($perGram, 6),
            'purity'     => $purity,
            'rate'       => $buyRate,
        ]);
    }

    public function store(Request $request)
    {
        // Base validation (common to all modes)
        $baseRules = [
            'checkout_mode' => ['nullable', Rule::in(['auth','guest','register'])],
            'name'   => ['nullable','string','max:120'],
            'email'  => ['nullable','email','max:255'],
            'phone'  => ['nullable','string','max:50'],
            'notes'  => ['nullable','string','max:5000'],

            'items'                           => ['required','array','min:1'],
            'items.*.catalog_item_id'         => ['nullable','integer','min:0'],
            'items.*.item_label'              => ['nullable','string','max:255'],
            'items.*.item_key'                => ['nullable','string','max:64'],
            'items.*.metal'                   => ['required', Rule::in(['gold','silver','platinum','palladium'])],
            'items.*.purity_label'            => ['required','string','max:50'],
            'items.*.qty'                     => ['required','integer','min:1','max:9999'],
            'items.*.weight_g'                => ['required','numeric','min:0.001','max:100000'],
            'items.*.photo'                   => ['nullable','image','max:5120'],
        ];

        // Additional rules when registering
        $mode = $request->input('checkout_mode', auth()->check() ? 'auth' : 'guest');

        if ($mode === 'register') {
            $baseRules = array_merge($baseRules, [
                'first_name'            => ['required','string','max:80'],
                'last_name'             => ['required','string','max:80'],
                'email'                 => ['required','email','max:255', Rule::unique('users','email')],
                'phone'                 => ['required','string','max:50'],
                'password'              => ['required','string','min:8','confirmed'],
                'password_confirmation' => ['required','string','min:8'],
            ]);
        } elseif ($mode === 'guest') {
            // For guests, we still want contact so we can follow up
            $baseRules = array_merge($baseRules, [
                'first_name' => ['nullable','string','max:80'],
                'last_name'  => ['nullable','string','max:80'],
                'email'      => ['required','email','max:255'],
                'phone'      => ['required','string','max:50'],
            ]);
        }

        $validated = $request->validate($baseRules);

        // If registering: create user and log them in
        if ($mode === 'register' && !auth()->check()) {
            $user = User::create([
                'name'     => trim(($validated['first_name'] ?? '').' '.($validated['last_name'] ?? '')) ?: ($validated['email'] ?? ''),
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone'    => $validated['phone'] ?? null, // if your users table has 'phone'
            ]);
            Auth::login($user);
        }

        // Compose display name for inquiry (priority: request->name, else first+last, else user name/email)
        $displayName = $validated['name']
            ?? trim(($validated['first_name'] ?? '').' '.($validated['last_name'] ?? ''))
            ?? (auth()->user()->name ?? auth()->user()->email ?? null);

        return DB::transaction(function () use ($validated, $request, $displayName) {
            $inq = JewelleryTabMaster::create([
                'user_id' => auth()->id(),
                'fNameJew'    => $displayName,
                'emailJew'   => $validated['email'] ?? (auth()->user()->email ?? null),
                'contactNumberJew'   => $validated['phone'] ?? (auth()->user()->phone ?? null),
                'notes'   => $validated['notes'] ?? null,
                'status'  => 1,
            ]);

            $totalGrams = 0.0;
            $totalAmt   = 0.0;

            foreach ($validated['items'] as $i => $row) {
                $purity   = $this->purityFromLabel($row['purity_label']);
                $perGram  = $this->livePerGram($row['metal']);
                $buyRate  = $this->buyRate($row['item_key'] ?? null, $row['metal']);
                $qty      = (int)$row['qty'];

                // unit = intrinsic value for the line's single unit (weight_g * purity * spot per g * buyRate)
                $unit = $perGram * $purity * (float)$row['weight_g'] * $buyRate;
                $line = $unit * $qty;

                $path = null;
                if ($request->hasFile("items.$i.photo")) {
                    $path = $request->file("items.$i.photo")->store("sell-items/{$inq->id}", 'public');
                }

                $totalGrams += (float)$row['weight_g'] * $qty;
                $totalAmt   += $line;

                SellItem::create([
                    'sell_inquiry_id' => $inq->id,
                    'catalog_item_id' => $row['catalog_item_id'] ?? null,
                    'metal'           => $row['metal'],
                    'item_label'      => $row['item_label'] ?? $row['item_key'] ?? null,
                    'purity_label'    => $row['purity_label'],
                    'purity_factor'   => $purity,
                    'qty'             => $qty,
                    'weight_g'        => (float)$row['weight_g'],
                    'total_weight_g'  => (float)$row['weight_g'] * $qty,
                    'unit_price'      => round($unit, 2),
                    'line_total'      => round($line, 2),
                    'photo_path'      => $path,
                ]);
            }

            $inq->update([
                'total_grams'  => round($totalGrams, 3),
                'total_points' => 0,
                'expectedPriceJew' => round($totalAmt, 2),
            ]);

            return redirect()
                ->route('sell.index')
                ->with('success', 'Thank you! Your inquiry has been submitted.');
        });
    }

    /* ----------------- helpers ----------------- */

    /** Use PricingService to get live per-gram (GBP) by UI metal */
    private function livePerGram(string $metal): float
    {
        $iso = self::UI_TO_ISO[strtolower($metal)] ?? 'XAU';
        // your PricingService exposes latestSpotPerGramGBP($iso)
        return (float) ($this->pricing->latestSpotPerGramGBP($iso) ?? 0.0);
    }

    /** Parse purity from label like `24ct (99.99%)`, `999.5 (99.95%)`, `22ct (91.6%)` */
    private function purityFromLabel(string $label): float
    {
        if (preg_match('/\(([\d\.]+)%\)/', $label, $m)) {
            return round(((float)$m[1] / 100), 5);
        }
        $l = strtolower($label);
        return match (true) {
            str_contains($l,'999.5') || str_contains($l,'995') => 0.9995,
            str_contains($l,'999')                             => 0.9990,
            str_contains($l,'950')                             => 0.9500,
            str_contains($l,'925')                             => 0.9250,
            str_contains($l,'916') || str_contains($l,'22')    => 0.9160,
            str_contains($l,'750') || str_contains($l,'18')    => 0.7500,
            str_contains($l,'585') || str_contains($l,'14')    => 0.5850,
            str_contains($l,'375') || str_contains($l,'9')     => 0.3750,
            str_contains($l,'24')                              => 0.9990,
            default                                            => 1.0,
        };
    }

    /**
     * Buy-rate percentage (what you pay vs spot).
     * Reads config('buyrates') if present; otherwise returns 1.0 (100%).
     */
    private function buyRate(?string $itemKey, string $metal): float
    {
        $items  = config('buyrates.items', []);
        $metals = config('buyrates.metals', []);
        $def    = (float) config('buyrates.default', 1.0);

        if ($itemKey && array_key_exists($itemKey, $items)) {
            return (float)$items[$itemKey];
        }
        $metal = strtolower($metal);
        if (array_key_exists($metal, $metals)) {
            return (float)$metals[$metal];
        }
        return $def;
    }
}
