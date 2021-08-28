<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrganisationStoreRequest extends FormRequest
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
            'name'          => 'required|min:2|max:64|unique:organisations',
            'description'   => 'required|min:4|max:255'
        ];
    }
}
