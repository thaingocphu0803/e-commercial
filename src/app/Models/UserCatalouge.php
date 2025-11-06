<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserCatalouge extends Model
{
    use HasFactory, Notifiable, SoftDeletes, QueryScope;

    protected $fillable = [
        'name',
        'description',
        'publish'
    ];

    public function users(){
        return $this->hasMany(User::class, 'user_catalouge_id', 'id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'user_catalouge_permission', 'user_catalouge_id', 'permission_id');
    }
}
