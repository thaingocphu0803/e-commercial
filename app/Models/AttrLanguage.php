<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttrLanguage extends Model
{
    protected $table = 'attr_language';

    protected $fillable = [
        'attr_id',
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
