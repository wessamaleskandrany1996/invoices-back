<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule as Rule;

class SupplierRequest extends BaseFormRequest
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
            'name' => 'required|string|min:3|max:255',
            'phone' => ['min:10|required', Rule::unique('suppliers')->ignore($this->supplier)]



        ];
    }
}
