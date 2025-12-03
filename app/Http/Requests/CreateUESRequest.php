<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUESRequest extends FormRequest
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
            'participant_id' => 'uuid|required',
            'fas1' => 'integer|required',
            'fas2' => 'integer|required',
            'fas3' => 'integer|required',
            'pus1' => 'integer|required',
            'pus2' => 'integer|required',
            'pus3' => 'integer|required',
            'aes1' => 'integer|required',
            'aes2' => 'integer|required',
            'aes3' => 'integer|required',
            'rws1' => 'integer|required',
            'rws2' => 'integer|required',
            'rws3' => 'integer|required',
        ];
    }
}
