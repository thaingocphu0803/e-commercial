<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class {ModuleName} extends Model
{
    use HasFactory, Notifiable, SoftDeletes, QueryScope;

    protected $fillable = [
        '{moduleName}_catalouge_id',
        'image',
        'icon',
        'album',
        'order',
        'publish',
        'user_id',
        'follow'
    ];

    public function languages(){
        return $this->belongsToMany(Language::class, '{moduleName}_language', '{moduleName}_id', 'language_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }

    public function {moduleName}Catalouges(){
        return $this->belongsToMany({ModuleName}Catalouge::class, '{moduleName}_catalouge_{moduleName}',  '{moduleName}_id' ,'{moduleName}_catalouge_id'  );
    }
}
