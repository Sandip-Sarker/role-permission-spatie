<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
        ];
    }
    public function index()
    {
        $data['users'] = User::orderBy('created_at', 'desc')->paginate(2);
        return view('backend.user.list')->with($data);
    }

    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::orderBy('name', 'asc')->get();
        $data['hasRoles'] = $data['user']->roles->pluck('id')->toArray();
        return view('backend.user.edit')->with($data);

    }

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user->update($request->all());

        $user->syncRoles($request->role);


        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
}
