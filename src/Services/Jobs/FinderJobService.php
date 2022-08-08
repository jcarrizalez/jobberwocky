<?php

namespace Avature\Services\Jobs;

use Illuminate\Support\Collection;
use Avature\Utils\Paginator;
use Avature\Utils\EloquentPaginator;
use Avature\Utils\Cache;
use Avature\Models\Job;
use Avature\Services\JobberwockyExternals\JobberwockyExternalService;

class FinderJobService
{
    protected Job $job;
    protected Cache $cache;
    protected EloquentPaginator $paginator;
    protected JobberwockyExternalService $jobberwockyService;

    public function __construct(
        Job $job,
        Cache $cache,
        EloquentPaginator $paginator,
        JobberwockyExternalService $jobberwockyService
    ) {
        $this->job = $job;
        $this->cache = $cache;
        $this->paginator = $paginator;
        $this->jobberwockyService = $jobberwockyService;
    }

    public function search(?string $search = null, Paginator $paginator): object
    {
        $cache = self::class.$search.$paginator->toString();

        if (null !== $response = $this->cache->get($cache)) {

            //return $response;
        }

        $this->jobberwockyService->make($search);

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
        return $elements->map(function (Job $job) {
            $job = (object) $job->toArray();

            if ($job->hidden_company) {
                $job->company = null;
            }

            unset($job->hidden_company);

            return $job;
        });
    }
}
