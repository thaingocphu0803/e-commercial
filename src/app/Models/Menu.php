<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Menu extends Model
{
    use NodeTrait;

    protected $fillable = [
        'menu_catalouge_id',
        'image',
        'icon',
        'album',
        'type',
        'publish',
        'order',
        'user_id',
        'parent_id',
        '_lft',
        '_rgt',
    ];

    public function menuCatalouge(){
        return $this->belongsTo(MenuCatalouge::class, 'menu_catalouge_id');
    }

    public function menuLanguage(){
        return $this->hasOne(MenuLanguage::class, 'menu_id');
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'menu_language', 'menu_id', 'language_id')
            ->withPivot(['name', 'canonical'])
            ->withTimestamps();
    }
}
