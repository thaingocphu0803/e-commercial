<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = [
        'order_id',
        'method_name',
        'payment_id',
        'payment_detail',
    ];

    protected $casts = [
        'payment_detail' => 'json'
    ];

    protected $table = 'order_payment';

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
