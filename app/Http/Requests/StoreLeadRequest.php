<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorize the request
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'service' => ['required', 'string'],
            'budget_range' => ['nullable', 'string'],
            'project_details' => ['nullable', 'string'],
            'privacy_agreed' => ['required', 'boolean'],
        ];
    }
}