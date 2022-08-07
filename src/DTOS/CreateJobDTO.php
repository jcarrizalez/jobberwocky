<?php
declare(strict_types=1);
namespace Avature\DTOS;

use App\Payloads\CreateJobPayload;

class CreateJobDTO  implements CreateJobPayload
{
    protected string $title;
    protected float $salary;
    protected int $country_id;
    protected ?int $company_id;
    protected string $external_service;
    protected array $skills;

    public function __construct(string $title, float $salary, int $country_id, ?int $company_id, string $external_service, array $skills)
    {
       $this->title = $title;
       $this->salary = $salary;
       $this->country_id = $country_id;
       $this->company_id = $company_id;
       $this->external_service = $external_service;
       $this->skills = $skills;
    }

    public function getUserId(): int
    {
        return 1;
    }

    public function getHiddenCompany(): bool
    {
        return true;
    }

    public function getCcountryId(): int
    {
        return $this->country_id;
    }
    public function getCompanyId(): ?int
    {
        return $this->company_id;
    }
    public function getSalary(): ?float
    {
        return $this->salary;
    }
    
    public function getExternalService(): ?string
    {
        return $this->external_service;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return null;
    }

    public function getSkills(): array
    {
        return array_column($this->skills, 'slug');
    }
}