<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use QueryScope, SoftDeletes;

    protected $fillable =[
        'name',
        'code',
        'description',
        'method',
        'discount_information',
        'not_end_time',
        'start_date',
        'end_date',
        'publish',
        'order',
        'discountValue',
        'discountType',
        'maxDiscountValue',
    ];

    protected $table = 'promotions';

    protected $casts = [
        'discount_information' => 'json'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_product_variant', 'promotion_id', 'product_id')
                ->withPivot('variant_uuid', 'model');
    }

    public function productCatalouges()
    {
        return $this->belongsToMany(ProductCatalouge::class, 'promotion_product_variant', 'promotion_id', 'product_id')
                ->withPivot('product_variant_id', 'model');
    }

}

