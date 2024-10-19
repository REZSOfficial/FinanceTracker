<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price field must be a number.',
            'date.required' => 'The date field is required.',
            'date.date' => 'The date field must be a date.',
        ];
    }
}
