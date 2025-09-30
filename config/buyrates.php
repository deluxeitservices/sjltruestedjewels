<?php

return [

    // Per-item overrides (use your UI keys)
    // VALUES ARE MULTIPLIERS: 0.85 = 85% of spot
    'items' => [
        'gold_jewellery'      => 0.99,   // scrap
        'gold_bar'            => 0.98,   // investment bar
        'gold_coin'           => 0.97,

        'silver_jewellery'    => 0.80,
        'silver_bar'          => 0.92,
        'silver_coin'         => 0.90,

        'platinum_jewellery'  => 0.88,
        'platinum_bar'        => 0.95,
        'platinum_coin'       => 0.94,

        'palladium_jewellery' => 0.88,
        'palladium_bar'       => 0.95,
        'palladium_coin'      => 0.94,
    ],
    // Fallback if nothing matches
    'default' => 0.90,
];
