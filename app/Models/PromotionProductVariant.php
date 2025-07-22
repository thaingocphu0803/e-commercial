<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionProductVariant extends Model
{
    protected $fillable = [
        'promotion_id',
        'product_id',
        'variant_uuid',
        'model'
    ];

    protected $table = 'promotion_product_variant';
}
