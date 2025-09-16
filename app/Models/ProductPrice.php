<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Services\PricingService;
use App\Models\ProductPriceSnapshot;

class ProductPrice extends Model
{
    protected $fillable = ['product_id','premium_pct','premium_flat','side'];
    public function product(){ return $this->belongsTo(Product::class); }

    protected static function booted(){
        static::saved(function(ProductPrice $rule){
            $svc = app(PricingService::class);
            $p = $rule->product()->with('priceRule')->first();
            if ($p) {
                $price = $svc->priceFor($p);
                if ($price !== null) {
                    ProductPriceSnapshot::create([
                        'product_id'=>$p->id,
                        'price_gbp'=>$price,
                        'spot_gbp_per_g'=>$svc->latestSpotPerGramGBP($p->metal) ?? 0,
                        'as_of'=>now(),
                    ]);
                }
            }
        });
    }
}
