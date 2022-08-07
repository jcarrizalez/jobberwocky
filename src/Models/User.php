<?php
declare(strict_types=1);
namespace Avature\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Avature\Models\Skill;

class User extends Model
{   
    protected $with = [
    ];

    public $hidden = [
        'id', 
        'created_at', 
        'updated_at',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function scopeGetAlertBySkills(Builder $query, array $slugs): Builder
    {
        $userIds = Skill::select('su.user_id')
            ->join('skill_user AS su', 'su.skill_id', 'skills.id')
            ->whereIn('skills.slug', $slugs);

        return $query->whereIn('id', $userIds);
    }
}