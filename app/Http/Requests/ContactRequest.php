<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{

    protected $rules = [];

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
          response()->json([
            'data' => $validator->errors(),
            'status' => false,
            'message' => "validation errors"
          ], 200)
        );
      }
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
        $rules = $this->rules;
        if(in_array('name', $this->form_field)) {
            $rules['name'] = 'required';
        }
        if(in_array('phone_number', $this->form_field)) {
            $rules['phone_number'] = 'required';
        }
        if(in_array('dob', $this->form_field)) {
            $rules['dob'] = 'required';
        }
        if(in_array('gender', $this->form_field)) {
            $rules['gender'] = 'required';
        }
        return $rules;
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => "name is required.",
            'phone_number.required' => "phone number is required.",
            'dob.required' => "date of birth is required.",
            'gender.required' => "gender is required."
        ];
    }
}
