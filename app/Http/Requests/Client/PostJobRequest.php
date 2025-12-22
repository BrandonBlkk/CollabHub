<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Psy\CodeCleaner\FunctionContextPass;

class PostJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string'],
            'skills_required' => ['required', 'array'],
            'experience_level' => ['required', 'string'],
            'duration' => ['required', 'string'],
            'budget_min' => ['required', 'numeric'],
            'budget_max' => ['required', 'numeric'],
            'is_featured' => ['required', 'boolean'],
            'is_private' => ['required', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.',
            'type.required' => 'Type is required.',
            'skills_required.required' => 'Skills required is required.',
            'experience_level.required' => 'Experience level is required.',
            'duration.required' => 'Duration is required.',
            'budget_min.required' => 'Budget min is required.',
            'budget_max.required' => 'Budget max is required.',
            'is_featured.required' => 'Is featured is required.',
            'is_private.required' => 'Is private is required.',
        ];
    }
}
