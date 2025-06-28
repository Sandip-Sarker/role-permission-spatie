<?php

namespace App\Http\Controllers\Backend\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:destroy roles', only: ['destroy']),
        ];
    }
    public function index()
    {
        $data['roles'] = Role::orderBy('created_at', 'desc')->paginate(5);
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
           'name' => 'required|unique:roles,name|string|max:20',
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
        $data['role']           = Role::findorFail($id);
        $data['hasPermissions'] = $data['role']->permissions->pluck('name')->toArray();
        $data['permission']     = Permission::orderBy('name', 'asc')->get();

        return view('backend.role.role.edit')->with($data);
    }

    public function update(Request $request, $id)
    {

        $role         = Role::findorFail($id);

        $validator = $request->validate([
            'name' => 'required|unique:roles,name,'.$id.',id',
        ]);

        if ($validator) {

            $role->name = $request->input('name');
            $role->save();

            if (is_array($request->input('permission'))) {
                $role->syncPermissions($request->input('permission'));
            }else
            {
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success', 'Role Added Successfully');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function destroy($id)
    {
        $role         = Role::find($id);

        if ($role == null) {

            session()->flash('error', 'Role Not Found');
            return response()->json([
                'staus' => false,
            ]);
        }

        $role->delete();

        session()->flash('success', 'Role Deleted Successfully');
        return response()->json([
            'staus' => true,

        ]);
    }

}
