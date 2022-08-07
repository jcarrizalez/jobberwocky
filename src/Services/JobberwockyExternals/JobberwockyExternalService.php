<?php

namespace Avature\Services\JobberwockyExternals;

use Avature\Utils\Cache;
use Avature\Models\Job;
use Avature\Models\Skill;
use Avature\Models\Country;
use Avature\Utils\HttpRequest;
use Illuminate\Support\Str;
use Avature\Utils\DB;
use Avature\DTOS\CreateJobDTO;
use Avature\Services\Jobs\CreateJobService; 


class JobberwockyExternalService
{
	protected HttpRequest $httpRequest;
	protected Job $job;
	protected Skill $skill;
	protected Country $country;
	protected CreateJobService $createJobService;

	protected const NAME = 'jobberwocky';

	protected string $url = 'http://api-avature-jobberwocky.local:8080/jobs';

	public function __construct(HttpRequest $httpRequest, DB $db, Job $job, Skill $skill, Country $country, CreateJobService $createJobService)
	{
		$this->httpRequest = $httpRequest;
		$this->db = $db;
		$this->job = $job;
		$this->skill = $skill;
		$this->country = $country;
		$this->createJobService = $createJobService;
	}

	public function make(?string $search = null): void
	{

		$response = $this->search($search);

		$this->create($response);
	}

	public function create(array $data): void
	{
		$this->db->transaction(function() use($data) {
			
			list($jobs, $countries, $skills) = $data;

				/**
				 * Sacar de aca, esto va en un servicio
				 */
				if(count($skills) !== 0){

					$this->skill->insert(array_values($skills));
				}

				/**
				 * Sacar de aca, esto va en un servicio
				 */
				if(count($countries) !== 0){

					$this->country->insert(array_values($countries));
				}

				foreach ($jobs as $job) {

					$country = $this->country->whereName($job['country'])->first()->id;
					$company_id = null;

					$jobPaylod = new CreateJobDTO(
						$job['title'],
						$job['salary'],
						$country,
						$company_id,
						$job['external_service'],
						$job['skills']
					);

					$this->createJobService->make($jobPaylod);
				}
			
			try {
			}catch (Exception $e) {

	        }
		});
	}

	public function search(?string $search = null): array
	{
		$params = $search ? "?name=$search" : '';

		$response = $this->getData($params);

		$skills = [];
		foreach ($response as &$job) {

			list($title, $salary, $country, $skill) = $job;

			$job = [
				'title' => $title,
				'salary' => (float) $salary,
				'country' => $country,
				'external_service' => self::NAME,
				'skills' => array_map(fn($item) => [
					'slug' => Str::slug($item), 
					'description' => $item, 
				], array_unique($skill))
			];

			foreach ($job['skills'] as $item) {
				$skills[$item['slug']] = $item;
			}
		}

		return [
			$this->filterJobs($response),
			$this->filterCountries($response),
			$this->filterSkills($response, $skills),
		];
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

	private function filterCountries(array $response): array
	{
		$countries = array_values(array_column($response, 'country'));
		$baseCountries = $this->country->names($countries);
		return array_filter($countries, function($country) use ($baseCountries) {
			return !in_array($country, $baseCountries);
		});
	}

	private function filterSkills(array $response, array $skills): array
	{
		$baseSkills = $this->skill->slugs(array_column($skills, 'slug'));
		return array_filter($skills, function($skill) use ($baseSkills) {
			return !in_array($skill, $baseSkills);
		}, ARRAY_FILTER_USE_KEY);
	}

	private function filterJobs(array $response): array
	{
		$titles = array_values(array_column($response, 'title'));
		$baseJobs = $this->job->jobberwockyTitles($titles);
		return array_filter($response, function($job) use ($baseJobs) {
			return !in_array($job['title'], $baseJobs);
		});
	}
}
		
