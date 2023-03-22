<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //     $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
    //     $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::get();
        return response()->json($role);
    }


    public function store(RoleRequest $request)
    {


        $role = Role::create(['name' => $request->input('name')]);
        if ($request->name == 'user') {

            $role->givePermissionTo('create-invoice');
            $role->save();
            // syncPermissions($request->input('permission'));
        } else if ($request->name == 'admin') {
            $permissions = Permission::pluck('id', 'id')->all();
            $role->syncPermissions($permissions);
            $role->save();
        } else {

            return " please enter roles Admin or user Olny";
        }


        return response()->json($role);
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);

        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        $role->syncPermissions($rolePermissions);


        return response()->json($role);
    }



    public function update(RoleRequest $request, $id)
    {

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return response()->json($role);
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return 'role is delet';
    }
}
