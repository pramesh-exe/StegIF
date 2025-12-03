<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTestRequest extends FormRequest
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
        // The arrays must be arrays of integers
        return [
            'participant_id' => 'uuid|required',
            'question1' => 'array|required',
            'question1.*' => 'integer',
            'question2' => 'array|required',
            'question2.*' => 'integer',
            'question3' => 'array|required',
            'question3.*' => 'integer',
            'question4' => 'integer|required',
            'question5' => 'integer|required',
            'question6' => 'array|required',
            'question6.*' => 'integer',
            'question7' => 'array|required',
            'question7.*' => 'integer',
            'question8' => 'integer|required',
            'question9' => 'integer|required',
            'time_since_start' => 'integer|required',
        ];
    }
}
