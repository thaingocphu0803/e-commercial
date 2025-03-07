<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class {ModuleTemplate} extends Model
{
    use HasFactory, Notifiable, SoftDeletes, QueryScope;

    protected $fillable = [
        '{moduleTemplate}_catalouge_id',
        'image',
        'icon',
        'album',
        'order',
        'publish',
        'user_id',
        'follow'
    ];

    public function languages(){
        return $this->belongsToMany(Language::class, '{moduleTemplate}_language', '{moduleTemplate}_id', 'language_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }

    public function {moduleTemplate}Catalouges(){
        return $this->belongsToMany({ModuleTemplate}Catalouge::class, '{moduleTemplate}_catalouge_{moduleTemplate}',  '{moduleTemplate}_id' ,'{moduleTemplate}_catalouge_id'  );
    }
}
