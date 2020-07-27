<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'mobile' => 'required|regex:/(01)[0-9]{9}/|unique:vendors,mobile,'.$this->id,
            'logo' => 'required_without:id|image|mimes:jpg,jpeg,png',
            'address' => 'required|string|max:500',
            'email' => 'required|email|unique:vendors,email,'.$this->id,
            'password' => 'required_without:id',
            'category_id' => 'required|exists:main_categories,id',
        ];
    }


//    public function messages()
//    {
//        return [
//            'required_without:id' => 'هذا العنصر مطلوب اذا لم يتواجد :attribute',
//
////            'required' => 'هذا الحقل مطلوب ',
////            'max' => 'القيمه المدخله اكبر من المطلوب',
////            'mimes' => 'برجاء اختيار صيغه متاحه للصوره (jpg,jpeg,png)',
////            'email' => 'صيغه البريد الالكترونى غير صالحه',
////            'string' => 'هذا الحقل لابد ان يكون نص',
////            'category_id.required' => 'asasas',
////            'category_id.exists' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
////            'mobile.regex' => 'ادخل رقم (مصرى صالح)',
//        ];
//    }


}
