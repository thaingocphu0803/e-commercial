<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Attr extends Model
{
    use HasFactory, Notifiable, SoftDeletes, QueryScope;

    protected $fillable = [
        'attr_catalouge_id',
        'image',
        'icon',
        'album',
        'order',
        'publish',
        'user_id',
        'follow'
    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'attr_language', 'attr_id', 'language_id')
            ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
            ->withTimestamps();
    }

    public function attrCatalouges()
    {
        return $this->belongsToMany(AttrCatalouge::class, 'attr_catalouge_attr',  'attr_id', 'attr_catalouge_id');
    }

    public function productVariant()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attr',  'attr_id', 'product_variant_id')
            ->withTimestamps();
    }

    public function attrLanguage(){
        return $this->hasMany(AttrLanguage::class, 'attr_id');
    }
}
