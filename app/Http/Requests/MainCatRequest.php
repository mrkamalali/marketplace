<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCatRequest extends FormRequest
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
            'photo' => 'required_without:id|mimes:jpg,jpeg,png',
            'category' => 'required|array|min:1',
            'category.*.name' => 'required',
            'category.*.abbr' => 'required',
            //'category.*.active' => 'required',  i Commented it  because  no need . i handle it in controller at function
        ];
    }
}
