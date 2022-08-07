<?php

declare(strict_types=1);

namespace App\Payloads;

interface CreateJobPayload
{
    public function getUserId(): int;

    public function getCcountryId(): int;
    
    public function getSalary(): ?float;

    public function getExternalService(): ?string;

    public function getHiddenCompany(): bool;
    
    public function getCompanyId(): ?int;

    public function getTitle(): ?string;

    public function getDescription(): ?string;

    public function getSkills(): array;
}