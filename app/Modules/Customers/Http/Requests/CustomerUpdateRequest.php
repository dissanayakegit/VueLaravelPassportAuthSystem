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
        $rules = [
            'customerName' => ['required', 'numeric'],
            'customerAddress' => ['required', 'max:20'],
            'customerEmail' => ['required', 'unique:customers,email'],
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
