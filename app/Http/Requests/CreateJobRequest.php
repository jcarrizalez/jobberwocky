<?php
declare( strict_types = 1 );
namespace App\Http\Requests;

use App\Payloads\CreateJobPayload;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Sacar esto de aca y pasar a un service
 */
use Avature\Models\Country;
use Avature\Models\Company;

class CreateJobRequest extends FormRequest implements CreateJobPayload
{
    protected const TITLE = 'title';
    protected const SALARY = 'salary';
    protected const COMPANY = 'company';
    protected const COUNTRY = 'country';
    protected const HIDDEN_COMPANY = 'hidden_company';
    protected const DESCRIPTION = 'description';
    protected const SKILLS = 'skills';

    public function getUserId(): int
    {
        return 1;
    }

    public function getCcountryId(): int
    {
        $country = Country::whereName($this->request->get(self::COUNTRY)['name'])->first();
        return !$country ? null : $country->id;
    }

    public function getExternalService(): ?string
    {
        return null;
    }

    public function getSalary(): ?float
    {
        $salary = $this->request->get(self::SALARY);

        return $salary ? ((float) $salary) : null;
    }

    public function getHiddenCompany(): bool
    {
        return boolval($this->request->get(self::HIDDEN_COMPANY));
    }

    public function getCompanyId(): ?int
    {
        $company = Company::whereName($this->request->get(self::COMPANY)['name'])->first();
        return !$company ? null : $company->id;
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
            self::DESCRIPTION => 'required|string',
            self::SKILLS => 'required|array',
            self::SKILLS .'.*.slug' => 'required|string|exists:skills,slug',
            self::COMPANY .'.name' => 'required|string|exists:companies,name',
            self::COUNTRY .'.name' => 'required|string|exists:countries,name',
        ];
    }
}