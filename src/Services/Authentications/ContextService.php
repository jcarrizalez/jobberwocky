<?php

declare(strict_types=1);

namespace Avature\Services\Authentications;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class ContextService
{
    protected $user_id;
    protected $time;

    public function __construct(Request $request)
    {
        dd(3333);
        foreach ($request->all() as $parameter => $value) {
            if (property_exists($this, $parameter)) {
                $this->{$parameter} = $value;
            }
        }
    }

    public function getAll()
    {
        return array_filter(get_object_vars($this));
    }


    public function addJwt($jwt)
    {
        try {
            //Convert Error 500-401 per token expired
            $jwtValues = JWT::decode($jwt, config('jwt.secret'), array('HS256'));
        } catch (Exception $e) {
            throw new Exception();
        }

        foreach ($jwtValues as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
        $this->validate();
    }

    public function getJWT($override = [])
    {
        $time = (int) ($this->time??60);

        $time = ($time < 1 || $time > 60) ? 60 : $time;

        $payload = [
            'iss' => "avature", // Issuer of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + $time*60 // Expiration time
        ];

        $properties = get_object_vars($this);
        foreach ($properties as $property => $value) {
            if (isset($override[$property])) {
                $payload[$property] = $override;
            } else {
                $payload[$property] = $value;
            }
        }

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, config('jwt.secret'));
    }
}
