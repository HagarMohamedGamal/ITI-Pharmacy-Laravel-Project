<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Pharmacy;
class UpdatePharmacyRequest extends FormRequest
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
        $pharmacy= Pharmacy::find(Request()->pharmacy);
        return [
            'name' => 'required|min:2',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($pharmacy->type->id),
            ],
            'national_id' => [
                Rule::unique('pharmacies')->ignore(Request()->pharmacy),
                'min:10'
            ],
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
