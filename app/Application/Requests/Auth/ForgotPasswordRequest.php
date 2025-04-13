<?php

namespace Application\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'nullable|email|exists:users,email',
            'username' => 'nullable|string|exists:users,username',
        ];
    }
}
