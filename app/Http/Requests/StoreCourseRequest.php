<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:courses,code', // Assuming the table name is 'courses'
            'description' => 'nullable|string',
            'summary' => 'nullable|string',
            'requirement' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0',
            'numOfHours' => 'nullable|integer|min:0',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
            'duration' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Adjust size as needed
            'files' => 'nullable|file|mimes:pdf,docx',
            'videos' => 'nullable|file|mimes:mp4,mov,avi',
            'status' => 'nullable|integer', // Assuming status can be an integer
            'level' => 'nullable|string',
            'teachers' => 'nullable|array', // Assuming teachers is an array
            'teachers.*' => 'exists:users,id', // Assuming teachers are user IDs
            'language' => 'nullable|string',
            'category_id' => 'required|exists:categories,id', // Ensure category exists    
        ];
    }

    public function messages()
    {
        return [
            //'name.required' => 'The course name is required.',
            //'code.unique' => 'The course code must be unique.',
            // Add any other custom messages here
            
        ];
    }
}
