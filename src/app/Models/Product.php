<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory, Notifiable, SoftDeletes, QueryScope;

    protected $fillable = [
        'product_catalouge_id',
        'image',
        'icon',
        'album',
        'order',
        'publish',
        'user_id',
        'follow',
        'code',
        'price'
    ];

    protected $table = 'products';

    public function languages(){
        return $this->belongsToMany(Language::class, 'product_language', 'product_id', 'language_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }

    public function productCatalouges(){
        return $this->belongsToMany(ProductCatalouge::class, 'product_catalouge_product',  'product_id' ,'product_catalouge_id'  );
    }

    public function productVariants(){
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_product_variant', 'product_id', 'promotion_id')
                ->withPivot('variant_uuid', 'model');
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
            ->withPivot(
                'uuid',
                'name',
                'qty',
                'price',
                'price_original',
                'promotion',
                'option'
            )->withTimestamps();
    }
}
