<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'description' => ['required', 'string', 'max:5000'],
            'type' => ['required', Rule::in(['fixed', 'hourly'])],
            'skills_required' => ['required', 'array', 'min:1'],
            'skills_required.*' => ['string', 'max:100', 'distinct'],
            'experience_level' => ['required', Rule::in(['entry', 'intermediate', 'expert'])],
            'duration' => ['required', Rule::in(['less_than_1_month', '1_to_3_months', '3_to_6_months', 'more_than_6_months'])],
            'budget_min' => ['required', 'numeric', 'min:0'],
            'budget_max' => ['required', 'numeric', 'gte:budget_min'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:today'],
            'status' => ['nullable', Rule::in(['draft', 'open'])],
            'is_featured' => ['boolean'],
            'is_private' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $skills = $this->input('skills_required');

        if (is_string($skills)) {
            $decoded = json_decode($skills, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $skills = $decoded;
            }
        }

        if (!is_array($skills)) {
            $skills = [];
        }

        $skills = array_values(array_filter(array_map(function ($skill) {
            return is_string($skill) ? trim($skill) : '';
        }, $skills)));

        $this->merge([
            'skills_required' => $skills,
            'is_featured' => $this->boolean('is_featured'),
            'is_private' => $this->boolean('is_private'),
            'status' => $this->input('status', 'open'),
        ]);
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.',
            'type.required' => 'Type is required.',
            'skills_required.required' => 'Skills required is required.',
            'skills_required.array' => 'Skills required must be a valid list.',
            'skills_required.min' => 'Please add at least one required skill.',
            'experience_level.required' => 'Experience level is required.',
            'duration.required' => 'Duration is required.',
            'budget_min.required' => 'Budget min is required.',
            'budget_max.required' => 'Budget max is required.',
            'budget_max.gte' => 'Budget max must be greater than or equal to budget min.',
        ];
    }
}
