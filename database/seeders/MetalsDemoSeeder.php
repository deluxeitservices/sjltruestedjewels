<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductPrice;

class MetalsDemoSeeder extends Seeder
{
    public function run(): void {
        $items=[
            ['slug'=>'gold-1g','title'=>'1g Gold Bar','metal'=>'XAU','type'=>'bar','weight_g'=>1.000,'brand'=>'Valcambi','vat_exempt'=>true],
            ['slug'=>'gold-100g','title'=>'100g Gold Bar','metal'=>'XAU','type'=>'bar','weight_g'=>100.000,'brand'=>'Argor-Heraeus','vat_exempt'=>true],
            ['slug'=>'silver-100g','title'=>'100g Silver Bar','metal'=>'XAG','type'=>'bar','weight_g'=>100.000,'brand'=>'Royal Mint','vat_exempt'=>false],
            ['slug'=>'platinum-1oz','title'=>'1oz Platinum Bar','metal'=>'XPT','type'=>'bar','weight_g'=>31.104,'brand'=>'Valcambi','vat_exempt'=>false],
            ['slug'=>'palladium-1oz','title'=>'1oz Palladium Bar','metal'=>'XPD','type'=>'bar','weight_g'=>31.104,'brand'=>'Argor-Heraeus','vat_exempt'=>false],
        ];
        foreach($items as $it){ $p=Product::create($it+['fineness'=>999.9,'is_active'=>true]); ProductPrice::create(['product_id'=>$p->id,'premium_pct'=>0.025,'premium_flat'=>0,'side'=>'sell']); }
    }
}
