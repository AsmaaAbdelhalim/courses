<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreQuestionRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'exam_id' => 'required|exists:exams,id',
            'course_id' => 'sometimes|exists:courses,id',
            'question' => 'required|string|max:255',
            'image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|file|mimes:mp4,webm,ogg|max:4096',
            
            'answers' => 'required|array|min:1',
            'answers.*.answer' => 'required|string|max:255',
            'answers.*.correct' => 'nullable',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $correct = collect($this->answers)->where('correct', true);

            if ($correct->count() == 0) {
                $validator->errors()->add('answers', 'At least one correct answer required');
            }
        });
    }
}