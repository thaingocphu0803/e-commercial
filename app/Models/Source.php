<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use SoftDeletes, QueryScope;

    protected $fillable =[
        'name',
        'keyword',
        'description',
        'publish',
    ];

    public function customers(){
        return $this->hasMany(Customer::class, 'source_id', 'id');
    }
}
