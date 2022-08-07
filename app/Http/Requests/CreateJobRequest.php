<?php
declare( strict_types = 1 );
namespace App\Http\Requests;

use App\Payloads\CreateJobPayload;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest implements CreateJobPayload
{
    protected const TITLE = 'title';
    protected const COMPANY_ID = 'company_id';
    protected const HIDDEN_COMPANY = 'hidden_company';
    protected const DESCRIPTION = 'description';
    protected const SKILLS = 'skills';

    public function getUserId(): int
    {
        return 1;
    }

    public function getHiddenCompany(): int
    {
        return (int) $this->request->get(self::HIDDEN_COMPANY);
    }

    public function getCompanyId(): int
    {
        return (int) $this->request->get(self::COMPANY_ID);
    }

    public function getTitle(): ?string
    {
        return $this->request->get(self::TITLE);
    }

    public function getDescription(): ?string
    {
        return $this->request->get(self::DESCRIPTION);
    }

    public function getSkills(): array
    {
        return array_column($this->request->get(self::SKILLS), 'slug');
    }

    public function rules()
    {
        return [
            self::TITLE => 'required|string',
            self::HIDDEN_COMPANY => 'required|bool',
            self::COMPANY_ID => 'required|exists:companies,id',
            self::DESCRIPTION => 'required|string',
            self::SKILLS => 'required|array',
            self::SKILLS .'.*.slug' => 'required|string|exists:skills,slug',
        ];
    }
}