<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $fillable = [
        'keyword',
        'content',
        'user_id',
        'language_id'
    ];
}
