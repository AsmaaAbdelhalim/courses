<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePaymentRequest extends FormRequest
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
            'course_id' => 'required|integer|exists:courses,id',
            'user_id' => 'required|integer|exists:users,id',
            'total_price' => 'required|numeric',
            'currency' => 'required|string',
            'session_id' => 'required|string',
            'status' => 'required|string',
            'payment_intent' => 'required|string',
            'country' => 'required|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
        'user_id' => Auth::id(),
        ]);
    }
}
