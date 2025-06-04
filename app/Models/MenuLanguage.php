<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuLanguage extends Model
{
    protected $table = 'menu_language';

    protected $fillable = [
        'menu_id',
        'language_id',
        'name',
        'canonical'
    ];

    public function menus()
    {
        return $this->belongsTo(Menu::class, 'menu_id')
            ->withPivot('name', 'canonical')
            ->withTimestamps();
    }
}
