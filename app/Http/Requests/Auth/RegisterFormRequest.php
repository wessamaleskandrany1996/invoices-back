<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class RegisterFormRequest extends BaseFormRequest
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
   * @return array
   */
  public function rules()
  {
    return [
      'name'      => 'required|string|max:50',
      'email'     => 'required|email|unique:users|max:255',
      'password'  => 'required|string|max:50|min:5|same:password_confirmation',
      'password_confirmation'  => 'required|string|max:50|min:5',
    ];
  }
}
