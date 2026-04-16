<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitExamRequest extends FormRequest
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
            'answers'   => ['required', 'array', 'min:1'],
            'answers.*' => ['required', 'exists:answers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'answers.required' => 'Please answer the questions before submitting.',
            'answers.*.exists' => 'One of the selected answers is invalid.',
        ];
    }
}
