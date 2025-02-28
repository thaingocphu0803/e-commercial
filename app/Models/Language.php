<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;

class Language extends Model
{
    use HasFactory, Notifiable, SoftDeletes, NodeTrait, QueryScope;

    protected $table = 'languages';

    protected $fillable =[
        'name',
        'canonical',
        'image',
        'user_id',
        'description',
        'publish'
    ];


    public function postCatalouges(){
        return $this->belongsToMany(PostCatalouge::class, 'post_catalouge_language', 'language_id', 'post_catalouge_id')
                    ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
                    ->withTimestamps();
    }

    public function posts(){
        return $this->belongsToMany(Post::class, 'post_language', 'language_id','post_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }
}
