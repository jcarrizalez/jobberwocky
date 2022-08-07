<?php
declare(strict_types=1);
namespace Avature\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Country extends Model
{
    protected $hidden = [
        'id', 
        'created_at', 
        'updated_at'
    ];

    public function scopeNames(Builder $query, array $names) :array
    {
        return $query->whereIn('name', $names)->get()->pluck('name')->toArray(); 
    }
}
