<?php
// app/Models/OrderItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'external_id',
        'title',
        'qty',
        'unit_gbp',
        'line_gbp',
        'unit_net_gbp',
        'unit_vat_gbp',
        'line_net_gbp',
        'line_vat_gbp',
        'image_url',
    ];

    protected $casts = [
        'qty'          => 'int',
        'unit_gbp'     => 'decimal:2',
        'line_gbp'     => 'decimal:2',
        'unit_net_gbp' => 'decimal:2',
        'unit_vat_gbp' => 'decimal:2',
        'line_net_gbp' => 'decimal:2',
        'line_vat_gbp' => 'decimal:2',
    ];
}
