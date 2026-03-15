<?php

namespace App\Http\Requests\Client;

use Illuminate\Validation\Rule;

class UpdateJobRequest extends PostJobRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['status'] = ['nullable', Rule::in(['draft', 'open', 'in_progress', 'completed', 'closed'])];

        return $rules;
    }
}
