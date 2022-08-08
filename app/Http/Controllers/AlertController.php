<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Avature\Services\Alerts\FinderAlertService;
use Avature\Services\Alerts\CreateAlertService;
use App\Http\Requests\CreateAlertRequest;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function search(Request $request, FinderAlertService $finderService)
    {
        return jsend_success(
            $finderService->search($request->get('search'), $this->getPaginator())
        );
    }

    public function create(CreateAlertRequest $jobPaylod, CreateAlertService $createService)
    {
        return jsend_success(
            $createService->make($jobPaylod)
        );
    }
}
