<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id', 'external_id', 'title', 'sku', 'image_url', 'meta','prefix','slug'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }
}