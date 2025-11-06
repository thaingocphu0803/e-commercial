<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerCatalouge extends Model
{
    use SoftDeletes, QueryScope;

    protected $fillable = [
        'name',
        'description',
        'publish',
    ];

    public function customers(){
        return $this->hasMany(Customer::class, 'customer_catalouge_id', 'id');
    }
}
