<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserCatalougePermission extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'user_catalouge_permission';

    public function user_catalouge(){
        return $this->belongsTo(UserCatalouge::class, 'user_catalouge_id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
