<?php

declare(strict_types=1);

namespace Avature\Services\Authentications;

use Firebase\JWT\JWT;
use Avature\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function attempt(array $credentials): ?string
    {
    }
}
