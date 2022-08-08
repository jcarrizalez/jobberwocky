<?php

namespace App\Http\Middleware;

use Closure;

use Exception;

class AvatureAuth
{
    public function handle($request, Closure $next)
    {
        /**
        * au me falto
        *
        $authorization = ($request->headers->get('authorization')?:$request->cookie('Authorization'));

        if(!$authorization) {
            // Unauthorized response if token not there
            throw new Exception;
        }

        app('Context')->addJwt($authorization);
        */
        return $next($request);
    }
}
