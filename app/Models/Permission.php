<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    use Illuminate\Notifications\Notifiable;

class Permission extends Model
{
    use HasFactory, Notifiable, QueryScope;

    protected $fillable = [
        'name',
        'canonical'
    ];
}
