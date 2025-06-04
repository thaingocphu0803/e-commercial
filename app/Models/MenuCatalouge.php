<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuCatalouge extends Model
{
    use SoftDeletes, QueryScope;

    protected $fillable = [
        'name',
        'keyword',
        'publish'
    ];

    protected $table = 'menu_catalouges';

    public function menus()
    {
        return $this->hasMany(Menu::class, 'menu_catalouge_id');
    }
}
