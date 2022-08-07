<?php
declare(strict_types=1);
namespace Avature\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $hidden = [
        'id', 
        'created_at', 
        'updated_at'
    ];
}
