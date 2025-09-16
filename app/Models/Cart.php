<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['session_id','user_id','status','lock_expires_at'];
    protected $casts = ['lock_expires_at'=>'datetime'];
    public function items(){ return $this->hasMany(CartItem::class); }
}
