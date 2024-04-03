<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class DataFilesDifferenceRequest extends FormRequest
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
            'recentData' => ['required', File::types(['csv',])->min('1kb'),],
            'oldData' => ['required', File::types(['csv',])->min('1kb'),],
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
            'recentData.required' => 'A csv with the old data is missing',
            'oldData.required' => 'A csv with the new data is missing',
        ];
    }
}
