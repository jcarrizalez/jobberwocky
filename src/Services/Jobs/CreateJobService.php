<?php

namespace Avature\Services\Jobs;

use App\Payloads\CreateJobPayload;
use Avature\Utils\Cache;
use Avature\Utils\DB;
use Avature\Models\Job;
use Avature\Models\Skill;
use Avature\Services\Skills\FinderSkillService;
use Exception;

class CreateJobService
{
	protected DB $db;
	protected Job $job;
	protected Cache $cache;
	protected FinderSkillService $finderSkillService;

	public function __construct(
		DB $db,
		Job $job, 
		Cache $cache, 
		FinderSkillService $finderSkillService
	){
		$this->db = $db;
		$this->job = $job;
		$this->cache = $cache;
		$this->finderSkillService = $finderSkillService;
	}

	public function make(CreateJobPayload $payload): ?Job
	{
		$response = null;

		$this->db->transaction(function() use($payload, &$response) {

			
				$skills = $this->finderSkillService->getBySlugs($payload->getSkills());
				
				$job = $this->job->create($payload);

				$job->skills()->attach($skills->map(function(Skill $skill) use ($job){
					return [
						'job_id' => $job->id,
						'skill_id' => $skill->id,
					];
				}));

				$job->save();
			
				$response = $this->job->find($job->id);
			try {
			}catch (Exception $e) {

	        }
		});

		return $response;
	}
}
