<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends Model
{
    use SoftDeletes, QueryScope;

    protected $fillable = [
        'name',
        'keyword',
        'description',
        'item',
    ];

    // public function languages(){
    //     return $this->belongsToMany(Language::class, 'slide_language', 'slide_id', 'language_id');
    // }
}
