<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CSVLinesChangesRequest extends FormRequest
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
            'recentFile' => ['required', 'mimes:csv,txt', 'min:1',],
            'oldFile' => ['required', 'mimes:csv,txt', 'min:1',],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'recentFile.required' => 'A csv with the old data is missing',
            'oldFile.required' => 'A csv with the new data is missing',
        ];
    }
}
