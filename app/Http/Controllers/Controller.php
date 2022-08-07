<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Avature\Utils\Paginator;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    public function getPaginator(): Paginator
    {
        return new Paginator(request()->all());
    }
}
