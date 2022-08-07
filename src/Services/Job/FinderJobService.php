<?php

namespace Avature\Services\Job;

use Illuminate\Support\Collection;
use Avature\Utils\Paginator;
use Avature\Utils\EloquentPaginator;
use Avature\Utils\Cache;
use Avature\Models\Job;

class FinderJobService
{
	protected Job $job;
	protected Cache $cache;
	protected EloquentPaginator $paginator;
	protected FinderJobberwockyExteneralJobsService $jobberwockyService;

	public function __construct(
		Job $job, 
		Cache $cache, 
		FinderJobberwockyExteneralJobsService $jobberwockyService, 
		EloquentPaginator $paginator
	){
		$this->job = $job;
		$this->cache = $cache;
		$this->paginator = $paginator;
		$this->jobberwockyService = $jobberwockyService;
	}

	public function search(?string $search = null, Paginator $paginator): object
	{
		dd($this->jobberwockyService->search($search));
		$cache = self::class.$search.$paginator->toString();

        if(null !== $response = $this->cache->get($cache)){

            return $response;
        }

		$response = $this->paginator->paginate(
			$this->job->search($search), 
			$paginator
		);

		$response->elements = $this->hiddenCompany($response->elements);

		$this->cache->put($cache, $response);

		return $response;
	}

	private function hiddenCompany(Collection $elements): Collection
	{
		return $elements->map(function(Job $job){

			$job = (object) $job->toArray();

			if($job->hidden_company){
				$job->company = null;
			}

			unset($job->hidden_company);

			return $job;
		});
	}
}
