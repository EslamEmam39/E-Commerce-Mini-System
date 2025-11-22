<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . Auth::id(),
        ];
    }


        public function messages()
    {
        return [
            'name.string' => 'الاسم يجب أن يكون نصاً',
            'name.max'    => 'الاسم يجب ألا يزيد عن 255 حرفاً',

            'email.email'  => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.max'    => 'البريد الإلكتروني يجب ألا يزيد عن 255 حرفاً',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل',
        ];
    }
}
