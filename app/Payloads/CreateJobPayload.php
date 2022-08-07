<?php

declare(strict_types=1);

namespace App\Payloads;

interface CreateJobPayload
{
    public function getUserId(): int;
    
    public function getCompanyId(): int;

    public function getTitle(): ?string;

    public function getDescription(): ?string;

    public function getSkills(): array;
}