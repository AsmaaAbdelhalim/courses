<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|integer|min:1',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after:start_at',
            'total_grade' => 'sometimes|required|integer|min:0',
            'passing_grade' => 'sometimes|required|integer|min:0|max:total_grade',
            'user_id' => 'sometimes|required|exists:users,id',
            'category_id' => 'nullable|required|exists:categories,id',
            'course_id' => 'sometimes|exists:courses,id',
            'lesson_id' => 'nullable|exists:lessons,id',
        ];
    }
}
