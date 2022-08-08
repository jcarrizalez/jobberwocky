<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Avature\Services\Jobs\FinderJobService;
use Avature\Services\Jobs\CreateJobService;
use App\Http\Requests\CreateJobRequest;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function search(Request $request, FinderJobService $finderService)
    {
        return jsend_success(
            $finderService->search($request->get('search'), $this->getPaginator())
        );
    }

    public function create(CreateJobRequest $jobPaylod, CreateJobService $createService)
    {
        return jsend_success(
            $createService->make($jobPaylod)
        );
    }
}
