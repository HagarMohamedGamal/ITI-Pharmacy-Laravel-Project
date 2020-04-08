<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
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
            'gender' => [
                    'required',
                    Rule::in(['male', 'female']),
                ],
            'birth_day' => 'required|Date',
            'mobile' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name' => 'enter name is required > 2 chars'

        ];
    }

}
