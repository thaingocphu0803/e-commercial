<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCatalougePost extends Model
{
    protected $fillable = [
        'post_catalouge_id',
        'post_id',
    ];
}
