<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantAttr extends Model
{
    use HasFactory;

    protected $table = 'product_variant_attr';
    public $incrementing = false;
    protected $primaryKey = null;


    protected $fillable = [
        "product_variant_id",
        "attr_id",
    ];
}
