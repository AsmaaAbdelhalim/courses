<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreResultRequest extends FormRequest
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
            'exam_id' => 'required|integer|exists:exams,id',
            'score' => 'required',
            'correct_answers' => 'required',
            'attempts' => 'nullable',
            'passed' => 'nullable|boolean',

            //'answers' => 'required',  // This is removed
            //'answers.*' => 'required|integer',  // This is also removed
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
        'user_id' => Auth::id(),
        ]);
    }
}
