<?php

namespace App\Http\Requests\Auth;

use App\Rules\HumanName;
use Illuminate\Foundation\Http\FormRequest;

class FarmerRegisterRequest extends FormRequest
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
            'firstname' => ['required', new HumanName(), 'min:2', 'max:60'],
            'middlename' => ['nullable', new HumanName(), 'min:2', 'max:60'],
            'lastname' => ['required', new HumanName(), 'min:2', 'max:60'],
            'contact_number' => ['required', 'numeric', 'digits:10', 'unique:users'],
            'email' => ['nullable', 'email:rfc,dns', 'unique:users'],
            'gender' => ['nullable', 'in:male,female'],
            'farm_area' => ['required', 'numeric', 'min:1'],
            'farm_type' => ['required', 'in:Irrigated,Rainfed Upland, Rainfed Lowland'],
            'ownership_type' => ['required'],
            'region' => ['required',],
            'province' => ['required'],
            'municipality' => ['required'],
            'barangay' => ['required'],
            'street' => ['required'],
            'house_number' => ['required'],
        ];
    }
}
