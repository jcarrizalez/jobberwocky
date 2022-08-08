<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationRequest;
use Avature\Services\Authentications\LoginService;

class AuthenticationController extends Controller
{
    public function login(AuthenticationRequest $request, LoginService $loginService)
    {
        //$token = $loginService->attempt($request->getCredentials());
    }

    public function logout()
    {
    }

    public function refresh()
    {
    }
}
