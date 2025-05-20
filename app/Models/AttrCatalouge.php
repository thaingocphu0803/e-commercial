<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;

class AttrCatalouge extends Model
{
    use HasFactory, Notifiable, SoftDeletes, NodeTrait, QueryScope;

    protected $table = 'attr_catalouges';

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
        return $this->belongsToMany(Language::class, 'attr_catalouge_language', 'attr_catalouge_id', 'language_id')
        ->withPivot(['name', 'canonical', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description'])
        ->withTimestamps();
    }

    public function attrs(){
        return $this->belongsToMany(Attr::class, 'attr_catalouge_attr', 'attr_catalouge_id', 'attr_id');
    }

    public static function isNodeCheck($id){
        $attrCatalouge = AttrCatalouge::find($id);
       if(($attrCatalouge->_rgt - $attrCatalouge->_lft) != 1){
            return false;
       }

       return true;

    }
}
