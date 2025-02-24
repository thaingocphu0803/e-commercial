<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;

class PostCatalouge extends Model
{
    use HasFactory, Notifiable, SoftDeletes, NodeTrait;

    protected $table = 'post_catalouges';

    protected $fillable = [
        'parent_id',
        '_lft',
        '_rgt',
        'level',
        'image',
        'icon',
        'album',
        'publish',
        'order',
        'user_id',
        'follow'
    ];

    public function languages(){
        return $this->belongsToMany(Language::class, 'post_catalouge_language', 'post_catalouge_id', 'language_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }
}
