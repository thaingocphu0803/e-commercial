<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;


class PostCatalougeLanguage extends Model
{
    use HasFactory, Notifiable, SoftDeletes,NodeTrait;

    protected $table = 'post_catalouge_language';
    public $incrementing = false;
    protected $primaryKey = null;


    protected $fillable = [
        "name",
        "description",
        "content",
        "meta_title",
        "meta_keyword",
        "meta_description",
        "canonical",
        "language_id",
        "post_catalouge_id"
    ];
}
