<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SjlCompulsoryBuyingFormMaster extends Model
{
    protected $table = 'compulsory_buying_form_image';

    // Adjust column names if yours differ
    // protected $fillable = [
    //     'form_id',        // FK -> sjl_compulsory_buying_form_master.id
    //     'order_id',       // optional, convenience
    //     'user_id',        // optional, convenience
    //     'path',           // storage path, e.g. "declarations/123/file.jpg"
    //     'original_name',  // original client filename
    //     'mime',           // mime type
    //     'size',           // bytes
    // ];

    public function images()
    {
        return $this->hasMany(SjlCompulsoryBuyingFormImage::class, 'form_id');
    }
}
