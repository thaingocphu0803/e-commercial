<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    use HasFactory, Notifiable, SoftDeletes, QueryScope;

    protected $fillable = [
        'post_catalouge_id',
        'image',
        'icon',
        'album',
        'order',
        'publish',
        'user_id',
        'follow'
    ];

    public function languages(){
        return $this->belongsToMany(Language::class, 'post_language', 'post_id', 'language_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }

    public function postCatalouges(){
        return $this->belongsToMany(PostCatalouge::class, 'post_catalouge_post',  'post_id' ,'post_catalouge_id'  );
    }
}
