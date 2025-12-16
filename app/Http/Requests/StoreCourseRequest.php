<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'finished_at' => 'nullable|date|after_or_equal:started_at',
            'duration' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'files' => 'nullable|file|mimes:pdf,docx',
            'videos' => 'nullable|file|mimes:mp4,mov,avi',
            'status' => 'nullable|integer',
            'level' => 'nullable|string',
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:users,id',
            'language' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id'
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
        'user_id' => Auth::id(),
        //'category_id' => $this->route('category')->id,
        ]);
    }
}