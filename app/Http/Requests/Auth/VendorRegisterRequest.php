<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VendorRegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstname' =>
            [
                'required',
                '',
                'min:2',
                'max:60'
            ],

            'middle' =>
            [
                'nullable',
                'alpha_dash',
                'min:2',
                'max:60'
            ],

            'lastname' =>
            [
                'required',
                'alpha_dash',
                'min:2',
                'max:60'
            ],

            'contact_number' =>
            [
                'required',
                'numeric',
                'digits:10',
                'unique:users',

            ],

            'email' =>
            [
                'nullable',
                'email:rfc,dns,unique:users'
            ],

            'gender' =>
            [
                'nullable',
                'in:male,female'
            ],

            'profile_picture' =>
            [
                'nullable',
            ],

            'public_market_id' =>
            [
                'required',
                'exists:public_markets,id',
            ],

            'authorization' =>
            [
                'required'
            ]


        ];
    }
}
