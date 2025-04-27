<?php

namespace Application\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string',
            'rememberMe' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'username.exists' => 'User with this username was not found',
        ];
    }
}
