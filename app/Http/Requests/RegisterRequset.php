<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequset extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
         'name' => 'required|string|min:3|max:50',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',


        ];

    }

    public function messages()
    {
       return [
          'name.required' => 'يجب إدخال الاسم',
        'name.min' => 'الاسم يجب ألا يقل عن 3 حروف',

        'email.required' => 'يجب إدخال البريد الإلكتروني',
        'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
        'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',

        'password.required' => 'يجب إدخال كلمة المرور',
        'password.min' => 'كلمة المرور يجب ألا تقل عن 6 حروف',
        'password.confirmed' => 'كلمة المرور غير متطابقة',
       ] ;
    }
}
