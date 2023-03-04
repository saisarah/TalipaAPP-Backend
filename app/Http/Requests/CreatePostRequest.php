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
        return Auth::user()->isFarmer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'crop_id' => 'required|exists:crops,id',
            'unit' => 'required',
            'is_straight' => 'required|boolean',
            'caption' => 'required|max:1000',
            'attachments' => 'required|array|min:1',
            'attachments.*' => 'image',
            'prices' => 'required|array',
            'prices.*.price' => 'required|numeric|min:1',
            'prices.*.stock' => 'required|numeric|min:1'
        ];
    }
}
