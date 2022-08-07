<?php
declare(strict_types=1);
namespace Avature\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Avature\Models\Skill;
use Avature\Models\Company;
use App\Payloads\CreateJobPayload;

class Job extends Model
{   
    protected $table = 'jobs';

    protected $fillable = [
    ];

    protected $with = [
        'skills', 
        'company', 
    ];

    public $hidden = [
        'id', 
        'active', 
        'companies', 
        'user_id', 
        'company_id', 
        //'hidden_company', 
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

    public function scopeSearch(Builder $query, ?string $search = null) :Builder
    { 
        if($search !== null){

            $skills = Skill::select('js.job_id')
                ->join('job_skill AS js', 'js.skill_id', 'skills.id')
                ->where('skills.description', 'LIKE', "%{$search}%");

            $query
                ->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhereIn('id', $skills);
        }
        return $query->orderBy("{$this->table}.created_at", 'DESC'); 
    }

    public function create(CreateJobPayload$payload): self
    {
        $entity = new self;
        $entity->title = $payload->getTitle();
        $entity->user_id = $payload->getUserId();
        $entity->company_id = $payload->getCompanyId();
        $entity->description = $payload->getDescription();
        $entity->hidden_company = $payload->getHiddenCompany();
        $entity->save();

        return $entity;
    }

    /*
    $model                      = new $this->model;
        $model->code                = $code;
        $model->template_coupon_id  = $template_id;
        $model->updated_at          = null;
        $model->save();
        $model->id                  = $model->id??null;
        return (object) $model->toArray();



    public function scopeFile($query, string $slug, int $page) :Builder
    {
        return $query
            ->select("{$this->table}.folder","{$this->contents}.image")
            ->where("{$this->table}.slug", $slug)
            ->join($this->contents, function($join) use ($page){
                $join->on("{$this->contents}.book_id", "{$this->table}.id");
                $join->on("{$this->contents}.page", DB::raw($page));
            });
    }


    public function scopeContent($query, string $slug, $search = null) :Builder
    {
        $query
            ->select("{$this->contents}.page", "{$this->contents}.text_content")
            ->where("{$this->table}.slug", $slug)
            ->join($this->contents, "{$this->contents}.book_id", "{$this->table}.id");

        if($search !== null){
            $query->where("{$this->contents}.text_content", 'LIKE', "%{$search}%");
        }
        return $query->orderBy("{$this->contents}.page"); 
    }
    */
}
