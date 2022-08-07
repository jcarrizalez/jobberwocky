<?php

namespace Avature\Services\Job;

use Illuminate\Support\Collection;
use Avature\Utils\Paginator;
use Avature\Utils\EloquentPaginator;
use Avature\Utils\Cache;
use Avature\Models\Job;
use Avature\Utils\HttpRequest;

class FinderJobberwockyExteneralJobsService
{
	protected HttpRequest $httpRequest;
	protected Job $job;
	protected Cache $cache;
	protected EloquentPaginator $paginator;

	protected string $url = 'http://api-avature-jobberwocky.local:8080/jobs';

	public function __construct(HttpRequest $httpRequest, Job $job, Cache $cache, EloquentPaginator $paginator)
	{
		$this->httpRequest = $httpRequest;
		$this->job = $job;
		$this->cache = $cache;
		$this->paginator = $paginator;
	}

	public function search(?string $search = null): object
	{
		$params = $search ? "?name=$search" : '';

		$response = $this->getData($params);

		$cache = self::class.$search;

		dd($response);
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

	private function getData(string $params): ?array
	{
		if(null === $response = $this->httpRequest->get($this->url.$params)){
			return null;
		}
		
		return json_decode(
			preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $response->getBody()->getContents())
		);
	}
}
