<?php

namespace App\Http\Requests;

use App\Doctor;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
        $doctor = Doctor::find(Request()->doctor);
        return [
            'name'=> 'required|min:5',
            'email'=> [
                'email',
                'required',
                Rule::unique('users')->ignore($doctor->type->id)
            ],
            'password'=> 'required|min:6',
            'national_id'=> 'required|unique:App\Doctor,national_id|min:10',
            'pharmacy_id'=> 'exists:pharmacies,id',
            'avatar'=> 'image|mimes:jpeg,jpg'
        ];
    }
}
