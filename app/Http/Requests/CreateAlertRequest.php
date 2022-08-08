<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Payloads\CreateAlertPayload;
use Illuminate\Foundation\Http\FormRequest;

class CreateAlertRequest extends FormRequest implements CreateAlertPayload
{
    protected const SKILLS = 'skills';

    public function getUserId(): int
    {
        return 1;
    }

    public function getSkills(): array
    {
        return array_column($this->request->get(self::SKILLS), 'slug');
    }

    public function rules()
    {
        return [
            self::SKILLS => 'required|array',
            self::SKILLS .'.*.slug' => 'required|string|exists:skills,slug',
        ];
    }
}
