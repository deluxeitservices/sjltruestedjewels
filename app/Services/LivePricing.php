<?php

namespace App\Services;

class LivePricing
{
    // Replace with your real feed later
    public function purePerGram(): array
    {
        return [
            'gold'      => 63.50,
            'silver'    => 0.70,
            'platinum'  => 23.10,
            'palladium' => 26.40,
        ];
    }

    public function priceFor(string $metal, float $purityFactor, float $weightG): float
    {
        $map = $this->purePerGram();
        $base = $map[strtolower($metal)] ?? 0;
        return $base * $purityFactor * $weightG;
    }

    public function purityPreset(?string $label): float
    {
        if (!$label) return 1.0;
        if (preg_match('/\(([\d\.]+)%\)/', $label, $m)) {
            return round(((float)$m[1] / 100), 5);
        }
        $label = strtolower($label);
        return match(true) {
            str_contains($label,'24') || str_contains($label,'999')     => 0.999,
            str_contains($label,'22') || str_contains($label,'916')     => 0.916,
            str_contains($label,'18') || str_contains($label,'750')     => 0.750,
            str_contains($label,'14') || str_contains($label,'585')     => 0.585,
            str_contains($label,'9')  || str_contains($label,'375')     => 0.375,
            str_contains($label,'950')                                   => 0.950,
            str_contains($label,'999.5')                                 => 0.9995,
            default => 1.0
        };
    }
}
