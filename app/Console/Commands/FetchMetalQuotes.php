<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\MetalQuote;

class FetchMetalQuotes extends Command
{
    protected $signature = 'quotes:fetch';
    protected $description = 'Fetch XAU, XAG, XPT, XPD spot and cache per-gram GBP';
    public function handle(): int {
        $base=env('METALS_API_BASE'); $key=env('METALS_API_KEY'); $ccy=env('METALS_API_BASE_CCY','GBP');
        $resp=Http::timeout(12)->get("{$base}/latest",[ 'access_key'=>$key,'base'=>$ccy,'symbols'=>'XAU,XAG,XPT,XPD' ]);
        if($resp->failed()){ $this->error('API error: '.$resp->body()); return self::FAILURE; }
        $rates=$resp->json()['rates'] ?? []; $oz=31.1034768; $now=now(); $n=0;
        foreach(['XAU','XAG','XPT','XPD'] as $m){ $perOz=(float)($rates[$m]??0); if($perOz<=0) continue;
            MetalQuote::create([ 'metal'=>$m,'currency'=>'GBP','bid'=>$perOz,'ask'=>$perOz,'mid'=>$perOz,'per_gram'=>$perOz/$oz,'as_of'=>$now ]); $n++; }
        $this->info("Saved {$n} quotes at {$now}"); return self::SUCCESS;
    }
}
