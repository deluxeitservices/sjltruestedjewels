<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'cart_id','order_no','status','currency','subtotal_gbp','vat_gbp',
        'total_gbp','customer_email','customer_name','payment_intent_id',
        'checkout_session_id','paid_at','lock_expires_at'
    ];
    protected $casts = ['paid_at'=>'datetime','lock_expires_at'=>'datetime'];
    public function items(){ return $this->hasMany(OrderItem::class); }
    public function cart(){ return $this->belongsTo(Cart::class); }
}
