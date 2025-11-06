<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Province extends Model
{
    use HasFactory, Notifiable;

    public function districts(){
        return $this->hasMany(District::class, 'province_code', 'code');
    }

    public function users(){
        return $this->hasMany(User::class, 'province_id', 'code');
    }

    public function orders(){
        return $this->hasMany(Order::class, 'province_id', 'code');
    }
}
