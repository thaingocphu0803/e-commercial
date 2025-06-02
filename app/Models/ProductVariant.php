<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "user_id",
        "code",
        "name",
        "quantity",
        "sku",
        "price",
        "barcode",
        "filename",
        "url",
        "album",
        "publish",
        "attr_catalouge"
    ];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function attrs(){
        return $this->belongsToMany(Attr::class, 'product_variant_attr', 'product_variant_id', 'attr_id');
    }
}
