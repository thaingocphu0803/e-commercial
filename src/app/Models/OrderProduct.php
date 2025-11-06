<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'uuid',
        'name',
        'qty',
        'price_original',
        'option',
    ];

    protected $casts = [
        'payment_detail' => 'json'
    ];

    protected $table = 'order_product';
}
