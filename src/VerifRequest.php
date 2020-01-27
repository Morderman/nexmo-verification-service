<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifRequest extends FormRequest
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
            'request_id' => 'required',
            'code' => 'required',
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
            'request_id.required' => 'Request id is required.',
            'code.required' => 'Verification code is required.',
        ];
    }
}
