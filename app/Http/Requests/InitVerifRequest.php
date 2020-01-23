<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InitVerifRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number' => 'required|regex:/(380)[0-9]{9}/',
        ];
    }

    /**
     * Specify the messages if validation is wrong.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'number.required' => 'Phone number is required in order to proceed with verification.'
        ];
    }
}
