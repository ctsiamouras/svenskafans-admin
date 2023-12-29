<?php

namespace App\JsonApi\V1\Countries;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class CountryRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:countries,name', 'max:100'],
            'flagUrl' => ['nullable', 'string', 'max:255'],
        ];
    }
}
