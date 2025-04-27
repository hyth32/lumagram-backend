<?php

namespace Application\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => ['required', PasswordRules::defaults()],
        ];
    }
}
