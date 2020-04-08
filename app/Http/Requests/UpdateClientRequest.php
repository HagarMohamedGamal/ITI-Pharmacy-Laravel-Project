<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Client;
use App\User;

class UpdateClientRequest extends FormRequest
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
        $client= User::find(Request()->client);
        if($client)
        {
            $client= User::find(Request()->client);
            return [
                'name' => 'required|min:2',
                'email'=> [
                    'email',
                    'required',
                    Rule::unique('users')->ignore($client->id)
                ],
                'national_id' => [
                    Rule::unique('clients')->ignore($client->typeable->id),
                    'min:10'
                ],
                'avatar' => 'image|mimes:jpg,jpeg',
                'gender' => [
                        'required',
                        Rule::in(['male', 'female']),
                    ],
                'birth_day' => 'required|Date',
                'mobile' => 'required|numeric',
            ]; 
        }
        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'name xxx is required',
            'name.min'  => 'name must be larger than 2 chars',
        ];
    }
}
