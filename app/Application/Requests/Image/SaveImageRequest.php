<?php

namespace Application\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class SaveImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => 'required|image',
        ];
    }
}
