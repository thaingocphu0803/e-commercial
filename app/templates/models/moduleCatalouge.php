<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;

class {ModuleCatalougeName} extends Model
{
    use HasFactory, Notifiable, SoftDeletes, NodeTrait, QueryScope;

    protected $table = '{tableCatalougeName}s';

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
        return $this->belongsToMany(Language::class, '{tableCatalougeName}_language', '{tableCatalougeName}_id', 'language_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }

    public function {moduleName}s(){
        return $this->belongsToMany({ModuleName}::class, '{tableCatalougeName}_{moduleName}', '{tableCatalougeName}_id', '{moduleName}_id');
    }

    public static function isNodeCheck($id){
        ${moduleCatalougeName} = {ModuleCatalougeName}::find($id);
       if((${moduleCatalougeName}->_rgt - ${moduleCatalougeName}->_lft) != 1){
            return false;
       }

       return true;

    }
}
