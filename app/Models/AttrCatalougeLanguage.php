<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;


class AttrCatalougeLanguage extends Model
{
    use HasFactory, Notifiable, NodeTrait;

    protected $table = 'attr_catalouge_language';
    public $incrementing = false;
    protected $primaryKey = null;


    protected $fillable = [
        "attr_catalouge_id",
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
