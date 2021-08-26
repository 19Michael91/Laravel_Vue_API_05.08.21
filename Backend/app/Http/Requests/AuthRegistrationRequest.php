<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRegistrationRequest extends FormRequest
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
     * Error response
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throw Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation($validator) {
        throw new HttpResponseException(
                response(['success'   => false,
                          'message'   => $validator->errors()], 400)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'email|required|unique:users',
            'name'      => 'required|min:5|max:16|unique:users',
            'password'  => 'required|min:8|max:16'
        ];
    }
}
