<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class District extends Model
{
    use HasFactory, Notifiable;

    public function province(){
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function wards(){
        return $this->hasMany(Ward::class, 'district_code', 'code');
    }
}
