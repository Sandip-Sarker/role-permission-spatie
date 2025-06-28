<?php

namespace App\Http\Controllers\Backend\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $data['roles'] = Role::orderBy('created_at', 'desc')->paginate(3);
        return view('backend.role.role.list')->with($data);
    }

    public function create()
    {
        $data['permissions'] = Permission::orderBy('name', 'asc')->get();
        return view('backend.role.role.create')->with($data);
    }

    public function store(Request $request)
    {

       $validator = $request->validate([
           'name' => 'required|unique:roles,name|string|max:5',
       ]);

       if ($validator) {
           $role = new Role();
           $role->name = $request->input('name');
           $role->save();

           if (is_array($request->input('permission'))) {
               foreach ($request->input('permission') as $permission) {
                   $role->givePermissionTo($permission);
               }
           }

           return redirect()->route('roles.index')->with('success', 'Role Added Successfully');
       }else{
           return redirect()->route('roles.create')->withErrors($validator)->withInput();
       }

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

}
