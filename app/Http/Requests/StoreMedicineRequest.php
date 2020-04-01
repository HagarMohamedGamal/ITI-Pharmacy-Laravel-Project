<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'=> 'required|min:5',
            'type'=> 'required|min:5',
            'price'=> 'required|numeric',
            'quantity'=> 'required|numeric'

        ];
    }
}
