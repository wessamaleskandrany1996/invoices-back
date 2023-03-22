<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Permission;

class UserController extends Controller
{

    public function index()
    {
        $user = User::paginate(15);;
        return response()->json($user);
    }

    public function store(UserRequest $request)
    {

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return response()->json($user);
    }


    public function show($id)
    {
        $user = User::findOrFail($id);

        $role = Role::findById($id);
        $user->assignRole($role);
        return response()->json($user);
    }

    public function update(UserRequest $request, $id)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::findOrfail($id);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->update($input);
        $user->assignRole($request->input('roles'));

        return response()->json($user);
    }


    public function destroy($id)
    {
        User::find($id)->delete();
        return 'User deleted successfully';
    }
}
