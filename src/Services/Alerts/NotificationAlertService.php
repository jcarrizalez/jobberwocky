<?php

namespace Avature\Services\Alerts;

use Avature\Utils\DB;
use Avature\Models\User;
use Avature\Models\UserNotification;
use Avature\Models\Job;
use Exception;

class NotificationAlertService
{
    protected DB $db;
    protected User $user;
    protected UserNotification $userNotification;

    public function __construct(
        DB $db,
        User $user,
        UserNotification $userNotification
    ) {
        $this->db = $db;
        $this->user = $user;
        $this->userNotification = $userNotification;
    }

    public function make(Job $job): void
    {
        $this->db->transaction(function () use ($job) {
            try {
                $skills = array_column($job->skills()->get()->toArray(), 'slug');

                $this->user->getAlertBySkills($skills)->get()->each(function ($user) use ($job) {
                    $alert = $this->userNotification->create($user, $job);
                    $alert->save();
                });
            } catch (Exception $e) {
            }
        });
    }
}
