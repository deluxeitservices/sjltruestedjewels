<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SjlCompulsoryBuyingFormImage extends Model
{
    protected $table = 'sjl_compulsory_buying_form_image';

    // Adjust column names if yours differ
    protected $fillable = [
        'form_id',        // FK -> sjl_compulsory_buying_form_master.id
        'order_id',       // optional, convenience
        'user_id',        // optional, convenience
        'path',           // storage path, e.g. "declarations/123/file.jpg"
        'original_name',  // original client filename
        'mime',           // mime type
        'size',           // bytes
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(SjlCompulsoryBuyingFormMaster::class, 'form_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
