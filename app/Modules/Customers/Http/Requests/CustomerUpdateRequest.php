<?php

namespace App\Modules\Customers\Http\Requests;

use App\Rules\PhoneNumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = request()->route()->parameter('id');
        $rules = [
            'customerName' => ['required'],
            'customerAddress' => ['required', 'max:200'],
            'customerEmail' => ['required', 'unique:customers,email,'.$id.',id'],
            'customerContactNumber' => ['required', 'numeric', new PhoneNumberValidation],
        ];

        return $rules;

    }

    public function messages()
    {
        return [
            'customerName.required' => 'Customer name is required.',
            'customerAddress.required' => 'Customer address name is required.',
            'customerEmail.required' => 'Customer email is required.',
            'customerContactNumber.required' => 'Customer contact number is required.'
        ];
    }
}
