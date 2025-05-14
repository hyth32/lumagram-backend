<?php

namespace App\Http\Requests;

use Application\Requests\BaseListRequest;

class BaseSearchRequest extends BaseListRequest
{
    public function rules(): array
    {
        $this->mergeIfMissing([
            'offset' => 0,
            'limit' => 10,
            'searchQuery' => '',
        ]);

        return [
            ...parent::rules(),
            'searchQuery' => 'nullable|string',
        ];
    }
}
