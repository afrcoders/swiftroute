<?php

namespace App\Http\Requests\Deliveries;

use Illuminate\Foundation\Http\FormRequest;

class StoreStep2Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'loading_option_id' => ['required', 'exists:loading_options,id'],
            'items' => ['nullable', 'array'],
            'items.*.name' => ['required_with:items', 'string', 'max:255'],
            'items.*.quantity' => ['required_with:items', 'integer', 'min:1', 'max:999'],
            'customer_notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'loading_option_id.required' => 'Please select a loading option.',
            'items.*.name.required_with' => 'Each item must have a name.',
            'items.*.quantity.required_with' => 'Each item must have a quantity.',
        ];
    }
}
