<?php
declare( strict_types = 1 );
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRequest extends FormRequest
{
    public const EMAIL = 'email';
    public const PASSWORD = 'password';

    public function rules(): array
    {
        return [
            self::EMAIL => 'required|email',
            self::PASSWORD => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function getCredentials(): array
    {
        return [
            self::EMAIL => $this->request->get(self::EMAIL),
            self::PASSWORD => $this->request->get(self::PASSWORD),
        ];
    }
}
