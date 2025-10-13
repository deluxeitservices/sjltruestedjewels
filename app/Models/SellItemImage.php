<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellItemImage extends Model
{
    use HasFactory;
    protected $fillable = ['sell_item_id','path','original_name'];
    
    public function sellItem()
    {
        return $this->belongsTo(SellItem::class);
    }
}
