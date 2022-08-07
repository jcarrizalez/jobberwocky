<?php

declare(strict_types=1);

namespace App\Payloads;

interface CreateAlertPayload
{
    public function getUserId(): int;

    public function getSkills(): array;
}
