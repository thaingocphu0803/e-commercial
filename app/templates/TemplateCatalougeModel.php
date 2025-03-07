<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;

class {ModuleTemplate} extends Model
{
    use HasFactory, Notifiable, SoftDeletes, NodeTrait, QueryScope;

    protected $table = '{moduleTable}s';

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
        return $this->belongsToMany(Language::class, '{moduleTable}_language', '{moduleTable}_id', 'language_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }

    public function {relation}s(){
        return $this->belongsToMany({relationModel}::class, '{moduleTable}_{relation}', '{moduleTable}_id', '{relation}_id');
    }

    public static function isNodeCheck($id){
        ${moduleTemplate} = {ModuleTemplate}::find($id);
       if((${moduleTemplate}->_rgt - ${moduleTemplate}->_lft) != 1){
            return false;
       }

       return true;

    }
}
