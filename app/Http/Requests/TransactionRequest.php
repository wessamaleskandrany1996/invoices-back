<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends BaseFormRequest
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
            // 'product_id'=>'required|exists:products,id',
            'inventory_id'=> 'required|exists:inventories,id',
            'shop_id'=> 'required|exists:inventories,id',
            // 'product'=> 'required|exists:productss,id',
            // 'product[][amount]'=> 'required'
        ];
    }
}
