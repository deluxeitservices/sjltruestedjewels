<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\MetalQuote;

class MetalQuotesDemoSeeder extends Seeder
{
    public function run(): void {
        $base='2025-09-06 15:'; $rows=[];
        $snap=[
            ['XAU',1798.00],['XAG',22.50],['XPT',730.00],['XPD',950.00],
            ['XAU',1802.40],['XAG',22.62],['XPT',732.10],['XPD',952.30],
        ];
        $i=0;
        foreach($snap as $s){
            $rows[] = ['metal'=>$s[0],'perOz'=>$s[1],'ts'=>sprintf('%s%02d:00',$base, ($i*5)%60)]; $i++;
        }
        $oz=31.1034768;
        foreach($rows as $r){
            MetalQuote::create([
                'metal'=>$r['metal'],'currency'=>'GBP','bid'=>$r['perOz'],'ask'=>$r['perOz'],'mid'=>$r['perOz'],
                'per_gram'=>$r['perOz']/$oz,'as_of'=>$r['ts'],
            ]);
        }
    }
}
