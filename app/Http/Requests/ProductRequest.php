<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends BaseFormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=> 'required|string|min:3|max:20',
            'sell_price'=> 'required|numeric|gt:0',
            // 'amount'=> 'required|numeric|gt:0',
            'category_id'=> 'required|exists:categories,id'
        ];
    }
}
