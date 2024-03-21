<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:1023'],
            'description' => ['nullable', 'string'],
            'is_private' => ['nullable', 'boolean'],
            'questions' => ['required', 'array'],
            'questions.*.component' => ['required', 'exists:types,component'],
            'questions.*.type_id' => ['required', 'exists:types,id'],
            'questions.*.label' => ['required', 'string'],
            'questions.*.description' => ['nullable', 'string'],
            'questions.*.required' => ['nullable', 'boolean'],
            'questions.*.order' => ['required', 'numeric'],
            'questions.*.value' => ['nullable', 'max:2048'],
            'questions.*.score' => ['nullable', 'numeric'],
            'questions.*.values' => ['nullable', 'array'],
            'questions.*.values.*.label' => ['nullable', 'string'],
            'questions.*.values.*.score' => ['nullable', 'numeric'],
            'questions.*.options' => ['nullable', 'array'],
        ];
    }
}
