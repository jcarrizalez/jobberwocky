<?php
declare(strict_types=1);
namespace Avature\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Avature\Models\Skill;
use Avature\Models\Company;
use Avature\Models\Country;
use App\Payloads\CreateJobPayload;

class Job extends Model
{   
    protected $table = 'jobs';

    protected $with = [
        'skills', 
        'country', 
        'company', 
    ];

    public $hidden = [
        'id', 
        'active', 
        'companies', 
        'user_id', 
        'company_id', 
        'country_id', 
        'companies', 
        'created_at', 
        'updated_at',
    ];

    public function getHidden()
    {
        return $this->hidden;
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeSearch(Builder $query, ?string $search = null) :Builder
    { 
        if($search !== null){

            $skills = Skill::select('js.job_id')
                ->join('job_skill AS js', 'js.skill_id', 'skills.id')
                ->where('skills.description', 'LIKE', "%{$search}%");

            $countries = Country::select('id')->where('name', 'LIKE', "%{$search}%");

            $companies = Company::select('id')->where('name', 'LIKE', "%{$search}%");

            $query
                ->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('salary', 'LIKE', "%{$search}%")
                ->orWhereIn('country_id', $countries)
                ->orWhereIn('company_id', $companies)
                ->orWhereIn('id', $skills);
        }
        return $query->orderBy("{$this->table}.created_at", 'DESC'); 
    }

    public function create(CreateJobPayload $payload): self
    {
        $entity = new self;
        $entity->title = $payload->getTitle();
        $entity->user_id = $payload->getUserId();
        $entity->salary = $payload->getSalary();
        $entity->company_id = $payload->getCompanyId();
        $entity->country_id = $payload->getCcountryId();
        $entity->external_service = $payload->getExternalService();
        $entity->description = $payload->getDescription();
        $entity->hidden_company = $payload->getHiddenCompany();
        $entity->save();

        return $entity;
    }

    public function jobberwockyTitles(array $titles) :array
    {
        return self::where('external_service', 'jobberwocky')->whereIn('title', $titles)->get()->pluck('title')->toArray(); 
    }
}