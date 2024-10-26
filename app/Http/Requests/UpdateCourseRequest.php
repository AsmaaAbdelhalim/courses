<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'description' => 'sometimes|required|string',
            'code' => 'sometimes|required|string|max:255',
            'summary' => 'sometimes|required|string',
            'requirement' => 'sometimes|required|string',
            'discount' => 'nullable|numeric',
            'numOfHours' => 'sometimes|required|integer',
            'started_at' => 'sometimes|required|date',
            'finished_at' => 'sometimes|required|date|after:started_at',
            'duration' => 'sometimes|required|integer',
            'status' => 'sometimes|required|in:active,inactive',
            'teachers' => 'sometimes|required|array',
            'teachers.*' => 'exists:users,id',
            'videos' => 'nullable|file|mimes:mp4,mov,avi',
            'files' => 'nullable|file',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    
        ];
    }
}
