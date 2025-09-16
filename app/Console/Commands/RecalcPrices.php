<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Services\PricingService;

class RecalcPrices extends Command
{
    protected $signature = 'prices:recalc';
    protected $description = 'Recalculate and snapshot prices for all active products';
    public function handle(PricingService $svc): int { $n=$svc->snapshotAllActive(); $this->info("Snapshotted {$n} products."); return self::SUCCESS; }
}
