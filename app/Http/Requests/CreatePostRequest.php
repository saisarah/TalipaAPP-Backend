<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->user_type == User::TYPE_FARMER;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'caption' => ['required', 'max:2000'],
            'payment_option' => ['required', 'in:cash,gcash'],
            'delivery_option' => ['required', 'in:pick-up,farmer,third-party'],
            'unit' => ['required'],
            'pricing_type' => ['required'],
            'min_order' => ['required'],
            'crop_id' => ['required', 'exists:crops,id'],
        ];
    }
}
