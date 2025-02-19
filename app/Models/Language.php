<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Language extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable =[
        'name',
        'canonical',
        'image',
        'user_id',
        'description',
        'publish'
    ];
}
