<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create','store']]);
        $this->middleware('permission:update user', ['only' => ['update','edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $users = User::all();
            return view('role-permission.user.index', ['users' => $users]);
        } catch (\Exception $e) {
            Alert::toast('Failed to load users: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $roles = Role::pluck('name','name')->all();
            return view('role-permission.user.create', ['roles' => $roles]);
        } catch (\Exception $e) {
            Alert::toast('Failed to load roles: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->syncRoles($request->roles);
            Alert::toast('User created successfully with roles', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to create user: ' . $e->getMessage(), 'error');
        }

        return redirect('/users');
    }

    public function edit(User $user)
    {
        try {
            $roles = Role::pluck('name','name')->all();
            $userRoles = $user->roles->pluck('name','name')->all();
            return view('role-permission.user.edit', [
                'user' => $user,
                'roles' => $roles,
                'userRoles' => $userRoles
            ]);
        } catch (\Exception $e) {
            Alert::toast('Failed to load user or roles: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        try {
            $user->update($data);
            $user->syncRoles($request->roles);
            Alert::toast('User Updated Successfully with roles', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to update user: ' . $e->getMessage(), 'error');
        }

        return redirect('/users');
    }

    public function destroy($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();
            Alert::toast('User Deleted Successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to delete user: ' . $e->getMessage(), 'error');
        }

        return redirect('/users');
    }
}
