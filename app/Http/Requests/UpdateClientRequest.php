<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
        $client= Client::find(Request()->client);
        // $user = User::find($client->type->id);
        // dd($user);
        return [
            'name' => 'required|min:2',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($client->type->id),
            ],
            'national_id' => [
                Rule::unique('clients')->ignore(Request()->client),
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

    public function messages()
    {
        return [
            'name.required' => 'name xxx is required',
            'name.min'  => 'name must be larger than 2 chars',
        ];
    }
}
