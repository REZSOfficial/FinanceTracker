<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomingRequest extends FormRequest
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
            'title' => 'required|max:32',
            'regular' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'type_of_payment' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title field must not be greater than 32 characters.',
            'regular.required' => 'The regular field is required.',
            'amount.required' => 'The amount field is required.',
            'type.required' => 'The type field is required.',
            'type_of_payment.required' => 'The type of payment field is required.',
        ];
    }
}
