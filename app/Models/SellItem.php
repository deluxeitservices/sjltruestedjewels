<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellItem extends Model
{
    protected $fillable = [
        'sell_inquiry_id','catalog_item_id','metal','item_label','purity_label','purity_factor',
        'qty','weight_g','total_weight_g','unit_price','line_total','photo_path'
    ];

    public function inquiry(): BelongsTo {
        return $this->belongsTo(JewelleryTabMaster::class,'sell_inquiry_id');
    }
}
