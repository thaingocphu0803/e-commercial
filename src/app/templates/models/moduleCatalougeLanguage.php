<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;


class {ModuleCatalougeName}Language extends Model
{
    use HasFactory, Notifiable, NodeTrait;

    protected $table = '{tableCatalougeName}_language';
    public $incrementing = false;
    protected $primaryKey = null;


    protected $fillable = [
        "{tableCatalougeName}_id",
        "language_id",
        "name",
        "description",
        "content",
        "meta_title",
        "meta_keyword",
        "meta_description",
        "canonical",
    ];
}
