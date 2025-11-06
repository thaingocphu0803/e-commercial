<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use SoftDeletes, QueryScope, Notifiable;

    protected $fillable = [
        'customer_catalouge_id',
        'source_id',
        'name',
        'phone',
        'province_id',
        'district_id',
        'ward_id',
        'address',
        'birthday',
        'image',
        'description',
        'user_agent',
        'ip',
        'email',
        'email_verified_at',
        'password',
        'publish',
        'gender'
    ];

    protected $attributes = [
        'publish' => 1
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function province (){
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function district (){
        return $this->belongsTo(District::class, 'district_id', 'code');
    }

    public function ward (){
        return $this->belongsTo(Ward::class, 'ward_id', 'code');
    }

    public function customerCatalouge(){
        return $this->belongsTo(CustomerCatalouge::class, 'customer_catalouge_id', 'id');
    }

    public function source(){
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }
}
