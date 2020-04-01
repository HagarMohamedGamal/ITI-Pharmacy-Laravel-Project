<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
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
        // dd($this);
        return [
            'area_id'=> 'required|min:1|max:10',
            'street_name' => 'required|min:1|max:30',
            'build_no' => 'min:1|max:10',
            'floor_no' => 'required|min:1|max:5',
            'flat_no' => 'min:1|max:10',
            'is_main' => 'required|boolean'
        ];
    }
}
