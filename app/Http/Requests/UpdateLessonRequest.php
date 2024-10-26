<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'content' => 'nullable|longText',
            'files' => 'nullable|string',
            'links' => 'nullable|string',
            'videos' => 'nullable|string',
            'audios' => 'nullable|string',
            'image' => 'nullable|string',
            'session' => 'nullable|string',
            'summary' => 'nullable|string',
            'position' => 'nullable|integer',
            'published_at' => 'nullable|date',
            'course_id' => 'sometimes|required|exists:courses,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'completed' => 'nullable|boolean',
            'completed_at' => 'nullable|date',
        ];
    }
}
