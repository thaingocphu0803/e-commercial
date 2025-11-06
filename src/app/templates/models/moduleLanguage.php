<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class {ModuleName}Language extends Model
{
    protected $table = '{moduleName}_language';

    protected $fillable = [
        '{moduleName}_id',
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
