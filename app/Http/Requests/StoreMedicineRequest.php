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
            'name'=> 'required|min:2',
            'type'=> 'required|min:2',
            'price'=> 'required|numeric',
            'quantity'=> 'required|numeric'

        ];
    }
}
