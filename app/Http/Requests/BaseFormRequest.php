<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{

  /**
   * Handle a failed validation attempt.
   *
   * @param  \Illuminate\Contracts\Validation\Validator  $validator
   * @return void
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  protected function failedValidation(Validator $validator)
  {
    $res = [
      'message' => 'Validation error', //Massage Return in Response Data field
      'status' => false,
      'error' => $validator->errors() //Validator Errors
    ];

    throw new HttpResponseException(response()->json($res));
  }

  //   public function rules()
  // {
  //   return [
  //     'name'          =>  'required|string|max:100',
  //     'phone'         =>  'nullable|integer|numeric',
  //     'shift'         =>  'nullable',
  //     'gender'        =>  'nullable|in:أنثى,ذكر|string',
  //     'status'        =>  'nullable|string',
  //     'birthday'      =>  'nullable|date',
  //     'ip_personal'   =>  'nullable|numeric|integer|digits:14',
  //     'visa_num'      =>  'nullable|numeric|integer',
  //     'visa_date'     =>  'nullable|date',
  //     'visa_fees'     =>  'nullable|integer|numeric',
  //     'salary'        =>  'nullable|numeric',
  //     'nationality'   =>  'nullable|string',
  //     'hiring_date'   =>  'nullable|date',
  //     'year_balance'  =>  'nullable|date',
  //     'work_hours'    =>  'nullable|integer',
  //     'img'           =>  'nullable|image',
  //     'position_id'   =>  'required|integer|exists:positions,id',
  //     'location_id'   =>  'required|integer|exists:locations,id'
  //   ];
  // }
}
