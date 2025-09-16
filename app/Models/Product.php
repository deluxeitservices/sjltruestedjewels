<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'slug','title','brand','metal','type','weight_g','fineness',
        'vat_exempt','image_url','description','is_active'
    ];
    public function priceRule(){ return $this->hasOne(ProductPrice::class); }
    public function latestSnapshot(){ return $this->hasOne(ProductPriceSnapshot::class)->latestOfMany('as_of'); }
}
