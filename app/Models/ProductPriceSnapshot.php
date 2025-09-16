<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductPriceSnapshot extends Model
{
    protected $fillable = ['product_id','price_gbp','spot_gbp_per_g','as_of'];
    protected $casts = ['as_of'=>'datetime'];
    public function product(){ return $this->belongsTo(Product::class); }
}
