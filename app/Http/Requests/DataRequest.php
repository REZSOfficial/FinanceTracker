<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataRequest extends FormRequest
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
            'food_drink' => 'integer',
            'housing' => 'integer',
            'transportation' => 'integer',
            'healthcare' => 'integer',
            'entertainment' => 'integer',
            'other' => 'integer',
        ];
    }

    public function messages(): array
    {
        return [
            'food_drink.integer' => 'The food and drink field must be an integer.',
            'housing.integer' => 'The housing field must be an integer.',
            'transportation.integer' => 'The transportation field must be an integer.',
            'healthcare.integer' => 'The healthcare field must be an integer.',
            'entertainment.integer' => 'The entertainment field must be an integer.',
            'other.integer' => 'The other field must be an integer.',
        ];
    }
}
