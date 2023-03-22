<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends BaseFormRequest
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
            'code' => 'required|unique:invoices',
            'total' => 'required|numeric|gt:0',
            'paid' => 'required|numeric|gte:0|lte:total',
            'status' => 'string|in:paid:postponed',
            'type' => 'required|string|in:sales:purchases'
        ];
    }
}
