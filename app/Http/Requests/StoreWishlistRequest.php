<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWishlistRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id'
        ];
    }

     /**
     * Get the validated data with additional fields.
     */
    protected function prepareForValidation(): void
    {
        $courseId = $this->route('course')->id;
        $this->merge([
        'user_id' => Auth::id(),
        'course_id' => $courseId,
        ]);
    }
}