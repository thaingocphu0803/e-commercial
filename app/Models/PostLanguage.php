<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostLanguage extends Model
{
    protected $fillable = [
        'post_id',
        'language_id',
        'name',
        'description',
        'content',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'canonical'
    ];
}
