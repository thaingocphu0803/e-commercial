<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ward extends Model
{
    use HasFactory, Notifiable;

    public function district(){
        return $this->belongsTo(District::class, 'district_code', 'code');
    }
}
