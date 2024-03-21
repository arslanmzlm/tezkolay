<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkspaceRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'logo' => ['nullable', 'max:1024'],
            'groups' => ['required', 'array'],
            'groups.*.name' => ['required', 'string'],
            'groups.*.size' => ['required', 'numeric', 'gte:0'],
            'groups.*.logo' => ['nullable', 'max:1024'],
        ];
    }
}
