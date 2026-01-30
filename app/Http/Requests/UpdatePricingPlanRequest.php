<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePricingPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'max_courses' => 'required|integer|min:1',
            'target_type' => 'required|in:group,individual',
            'delivery_mode' => 'required|in:one_to_many,one_on_one',
            'schedule_type' => 'required|in:fixed,choose,flexible',
            'is_popular' => 'nullable|boolean',
            'course_ids' => 'required|array|min:3|max:4',
            'course_ids.*' => 'required|exists:courses,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'course_ids.required' => 'Please select at least 3 courses for this package.',
            'course_ids.min' => 'A package must contain at least 3 courses.',
            'course_ids.max' => 'A package can contain a maximum of 4 courses.',
            'course_ids.*.exists' => 'One or more selected courses do not exist.',
            'max_courses.required' => 'Maximum courses field is required.',
            'max_courses.min' => 'Maximum courses must be at least 1.',
        ];
    }
}
