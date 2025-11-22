<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
              ];

    }



        public function messages()
    {
        return [
            'name.required' => 'اسم المنتج مطلوب',
            'name.string'   => 'اسم المنتج يجب أن يكون نصاً',
            'name.max'      => 'اسم المنتج لا يجب أن يزيد عن 255 حرفاً',

            'description.string' => 'الوصف يجب أن يكون نصاً',

            'price.required' => 'السعر مطلوب',
            'price.numeric'  => 'السعر يجب أن يكون رقمًا',
            'price.min'      => 'السعر يجب أن يكون 0 أو أكثر',

            'stock.required' => 'عدد المخزون مطلوب',
            'stock.integer'  => 'المخزون يجب أن يكون رقمًا صحيحًا',
            'stock.min'      => 'المخزون لا يمكن أن يكون أقل من 0',
        ];
    }
}
