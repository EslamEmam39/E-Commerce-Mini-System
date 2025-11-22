<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
        ];
    }



        public function messages()
    {
        return [
            'name.string'  => 'اسم المنتج يجب أن يكون نصاً',
            'name.max'     => 'اسم المنتج لا يجب أن يزيد عن 255 حرفاً',
            'description.string' => 'الوصف يجب أن يكون نصاً',
            'price.numeric' => 'السعر يجب أن يكون رقمًا',
            'price.min'     => 'السعر لا يمكن أن يكون أقل من 0',
            'stock.integer' => 'المخزون يجب أن يكون رقمًا صحيحًا',
            'stock.min'     => 'المخزون لا يمكن أن يكون أقل من 0',
        ];
    }
}
