<?php

namespace App\Http\Controllers\Backend\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:destroy permissions', only: ['destroy']),
        ];
    }
    public function index()
    {
        $data['permissions'] = Permission::orderBy('created_at', 'DESC')->paginate(10);
        return view('backend.role.permission.list')->with($data);
    }

    public function create()
    {
        return view('backend.role.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|string|unique:permissions,name|min:3',
        ]);

        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->save();

        return redirect()->route('roles.permission.index')->with('success', 'Permission created successfully');

    }

    public function edit($id)
    {
        $data['permission'] = Permission::find($id);
        return view('backend.role.permission.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);

        $request->validate([
            'name' => 'required|string|unique:permissions,name,'. $id .', id',
        ]);

        $permission->name = $request->input('name');
        $permission->save();
        return redirect()->route('roles.permission.index')->with('success', 'Permission updated successfully');

    }
    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        if ($permission == null) {

            session()->flash('error', 'Permission not found');
            return response()->json([
               'status' => false,
            ]);
        }

        session()->flash('success', 'Permission deleted successfully');

        return response()->json([
            'status' => true,
        ]);
    }
}
