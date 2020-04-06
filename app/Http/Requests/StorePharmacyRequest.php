<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePharmacyRequest extends FormRequest
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
            'name' => 'required|min:2',
            'email' => 'unique:App\User,email|required|email',
            'password' => 'required|min:6',
            'national_id' => 'unique:App\Pharmacy,national_id|min:10',
            'avatar' => 'image|mimes:jpg,jpeg',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'name.min'  => 'A name must be larger than 2 chars',
        ];
    }
}
