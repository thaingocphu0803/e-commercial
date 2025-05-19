<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;


class ProductCatalougeLanguage extends Model
{
    use HasFactory, Notifiable, SoftDeletes,NodeTrait;

    protected $table = 'product_catalouge_language';
    public $incrementing = false;
    protected $primaryKey = null;


    protected $fillable = [
        "product_catalouge_id",
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
