<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'address' => 'required|string|max:500',
            'phone'   => 'required|string|max:20',
        ];
    }

        public function messages()
    {
        return [
            'address.required' => 'عنوان الشحن مطلوب',
            'address.string'   => 'العنوان يجب أن يكون نصاً',
            'address.max'      => 'العنوان طويل جداً',

            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.string'   => 'رقم الهاتف يجب أن يكون نصاً',
            'phone.max'      => 'رقم الهاتف طويل جداً',
        ];
    }
}
