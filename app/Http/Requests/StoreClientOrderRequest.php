<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientOrderRequest extends FormRequest
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
            'delivering_address_id' => 'required|Numeric',
            'image.*' => 'required|image|mimes:jpg,jpeg',
            'is_insured' => [
                    'required',
                    Rule::in([1, 0]),
                ]
        ];
    }

    public function messages()
    {
        return [
            'is_insured' => 'is_insured must be 0 or 1'

        ];
    }
}
