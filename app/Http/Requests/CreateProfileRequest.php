<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfileRequest extends FormRequest
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
            'participant_id' => 'required|uuid',
            'age' => 'required|integer',
            'main_expertise' => 'required|string',
            'education' => 'required|string',
            'gaming_experience' => 'required|string',
            'cybersecurity' => 'required|string',
            'steganography' => 'required|string',
            'stego_explanation' => 'required|string',
        ];
    }
}
