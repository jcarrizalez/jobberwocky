<?php
declare(strict_types=1);
namespace Avature\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class Skill extends Model
{
    protected $hidden = [
        'id', 
        'pivot',
        'created_at', 
        'updated_at', 
    ];


    public function scopeSearch(Builder $query, ?string $search = null, $user = null) :Builder
    { 
        if($search !== null){
            
            $query->where('skills.description', 'LIKE', "%{$search}%");
        }

        $user = 1;

        if($user !== null){

            $skills = Skill::select('su.skill_id')
                ->join('skill_user AS su', 'su.skill_id', 'skills.id')
                ->where('skills.description', 'LIKE', "%{$search}%");

            $query->whereIn('skills.id', $skills);
        }
        
        return $query->orderBy("skills.created_at", 'DESC'); 
    }
}
