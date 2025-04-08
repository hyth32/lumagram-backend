<?php

namespace Application\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'activityCategory' => 'nullable|string',
            'isPublic' => 'required|boolean',
        ];
    }
}
