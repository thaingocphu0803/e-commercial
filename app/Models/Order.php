<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'fullname',
        'phone',
        'email',
        'province_id',
        'district_id',
        'ward_id',
        'address',
        'description',
        'promotion',
        'cart',
        'customer_id',
        'guest_cookie',
        'method',
        'confirm',
        'payment',
        'delivery',
        'shipping_fee'
    ];

    protected $casts = [
        'cart' => 'json',
        'promotion' => 'json'
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
            ->withPivot(
                'uuid',
                'name',
                'qty',
                'price',
                'price_original',
                'option'
            )->withTimestamps();
    }

    public function orderPayments () {
        return $this->hasMany(OrderPayment::class, 'order_id');
    }

    public function province (){
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function district (){
        return $this->belongsTo(District::class, 'district_id', 'code');
    }

    public function ward (){
        return $this->belongsTo(Ward::class, 'ward_id', 'code');
    }
}
