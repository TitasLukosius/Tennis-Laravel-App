<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
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
        return [
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'name' => 'required|string',
            'surname' => 'required|string',
            'age' =>'required|numeric',
            'gender' => 'required',
            'city' => 'required|string',
            'NTRP' => 'required',
            'description' => 'required|string',
        ];
    }
}
