<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;

class ProductCatalouge extends Model
{
    use HasFactory, Notifiable, SoftDeletes, NodeTrait, QueryScope;

    protected $table = 'product_catalouges';

    protected $fillable = [
        'parent_id',
        '_lft',
        '_rgt',
        'level',
        'image',
        'icon',
        'album',
        'publish',
        'order',
        'user_id',
        'follow'
    ];

    public function languages(){
        return $this->belongsToMany(Language::class, 'product_catalouge_language', 'product_catalouge_id', 'language_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'product_catalouge_product', 'product_catalouge_id', 'product_id');
    }

    public static function isNodeCheck($id){
        $productCatalouge = ProductCatalouge::find($id);
       if(($productCatalouge->_rgt - $productCatalouge->_lft) != 1){
            return false;
       }

       return true;

    }
}
