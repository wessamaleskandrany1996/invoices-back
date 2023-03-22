<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\UserResources;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginFormRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\RegisterFormRequest;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'email' => 'required|email|max:191|unique:users,email',
      'password' => 'required|string|max:50|min:5|same:password_confirmation',
      'password_confirmation'  => 'required|string|max:50|min:5',
      'inventory_id' => 'required'
    ]);
    if ($validator->fails()) {
      return response()->json([
        'validation_errors' => $validator->messages(),
      ]);
    } else {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'inventory_id' => $request->inventory_id
      ]);

      $token = $user->createToken($user->email . '_Token')->plainTextToken;
      return response()->json([
        'status' => 200,
        'username' => $user->name,
        'token' => $token,
        'inventory_id' => $user->inventory_id,
        'message' => 'User Added Successfully',
      ]);
    }
  }

  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email|max:191',
      'password' => 'required|min:5',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'validation_errors' => $validator->messages(),
      ]);
    } else {
      $user = User::where('email', $request->email)->first();

      if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
          'status' => 401,
          'message' => 'invalid credentials',
        ]);
      } else {
        $token = $user->createToken($user->email . '_Token')->plainTextToken;
        return response()->json([
          'status' => 200,
          'username' => $user->name,
          'token' => $token,
          'inventory_id' => $user->inventory_id,
          'message' => 'Logged In Successfully',
        ]);
      }
    }
  }

  public function logout(){
    auth()->user()->tokens()->delete();
    return response()->json([
        'status'=>200,
        'message'=>'logged out successfully',
    ]);
}
}
