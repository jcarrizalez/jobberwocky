<?php

namespace Avature\Services\Jobs;

use App\Payloads\CreateJobPayload;
use Avature\Utils\Cache;
use Avature\Utils\DB;
use Avature\Models\Job;
use Avature\Models\Skill;
use Avature\Services\Skills\FinderSkillService;
use Avature\Services\Alerts\NotificationAlertService;

use Exception;

class CreateJobService
{
    protected DB $db;
    protected Job $job;
    protected Cache $cache;
    protected FinderSkillService $finderSkillService;
    protected NotificationAlertService $notificationAlertService;

    public function __construct(
        DB $db,
        Job $job,
        Cache $cache,
        FinderSkillService $finderSkillService,
        NotificationAlertService $notificationAlertService
    ) {
        $this->db = $db;
        $this->job = $job;
        $this->cache = $cache;
        $this->finderSkillService = $finderSkillService;
        $this->notificationAlertService = $notificationAlertService;
    }

    public function make(CreateJobPayload $payload): ?Job
    {
        $job = null;

        $this->db->transaction(function () use ($payload, &$job) {
            try {
                $skills = $this->finderSkillService->getBySlugs($payload->getSkills());

                $job = $this->job->create($payload);

                $job->skills()->attach($skills->map(function (Skill $skill) use ($job) {
                    return [
                        'job_id' => $job->id,
                        'skill_id' => $skill->id,
                    ];
                }));

                $job->save();

                $job = $this->job->find($job->id);
            } catch (Exception $e) {
            }
        });

        if ($job) {
            $this->notificationAlertService->make($job);
        }

        return $job;
    }
}
