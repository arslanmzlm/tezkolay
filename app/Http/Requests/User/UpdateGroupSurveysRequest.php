<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupSurveysRequest extends FormRequest
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
            'surveys' => ['nullable', 'array'],
            'surveys.*.id' => ['nullable', 'exists:surveys,id'],
            'surveys.*.name' => ['required', 'string'],
            'surveys.*.template_id' => ['required', 'exists:templates,id'],
            'surveys.*.survey_at' => ['exclude_unless:surveys.*.id,null', 'required', 'date', 'after:today'],
        ];
    }
}
