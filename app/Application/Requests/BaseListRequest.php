<?php

namespace Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->mergeIfMissing([
            'offset' => 0,
            'limit' => 10,
        ]);

        return [
            'offset' => 'integer',
            'limit' => 'integer',
        ];
    }
}
