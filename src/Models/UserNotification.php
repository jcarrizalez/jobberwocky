<?php
declare(strict_types=1);
namespace Avature\Models;

use Illuminate\Database\Eloquent\Model;
use Avature\Models\User;
use Avature\Models\Job;

class UserNotification extends Model
{
    protected $table = 'user_notifications';

    public function create(User $user, Job $job): self
    {
        $skills = array_column($job->skills()->get()->toArray(), 'description');
        $skills = implode(', ', $skills);

        $entity = new self;
        $entity->user_id = $user->id;
        $entity->job_id = $job->id;
        $entity->description = "Puesto disponible para: [{$job->title}] y puedes aplicar [{$skills}]";
        return $entity;
    }
}
