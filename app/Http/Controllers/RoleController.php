<?php
namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create','store','addPermissionToRole','givePermissionToRole']]);
        $this->middleware('permission:update role', ['only' => ['update','edit']]);
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
        $this->middleware('permission:force delete role', ['only' => ['forceDelete']]);
    }

    public function index()
    {
        try {
            $roles = Role::all();
            return view('role-permission.role.index', compact('roles'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load roles: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('role-permission.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name'
        ]);

        try {
            Role::create([
                'name' => $request->name
            ]);
            Alert::toast('Role Created Successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to create role: ' . $e->getMessage(), 'error');
        }

        return redirect('roles');
    }

    public function edit(Role $role)
    {
        try {
            return view('role-permission.role.edit', ['role' => $role]);
        } catch (\Exception $e) {
            Alert::toast('Failed to load role for editing: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id
        ]);

        try {
            $role->update([
                'name' => $request->name
            ]);
            Alert::toast('Role Updated Successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to update role: ' . $e->getMessage(), 'error');
        }

        return redirect('roles');
    }

    public function destroy($roleId)
    {
        try {
            $role = Role::findOrFail($roleId);
            $role->delete(); // This should soft delete the role
            Alert::toast('Role Deleted Successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to delete role: ' . $e->getMessage(), 'error');
        }

        return redirect('roles');
    }

    public function restoreAll()
    {
        try {
            $roles = Role::all();
            $deletedRoles = Role::onlyTrashed()->get();
            return view('role-permission.role.restore', compact('roles', 'deletedRoles'));
        } catch (\Exception $e) {
            Alert::toast('Failed to load roles for restoration: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function restore($roleId)
    {
        try {
            $role = Role::withTrashed()->findOrFail($roleId);
            $role->restore();
            Alert::toast('Role Restored Successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to restore role: ' . $e->getMessage(), 'error');
        }

        return redirect('roles');
    }

    public function forceDelete($roleId)
    {
        try {
            $role = Role::withTrashed()->findOrFail($roleId);
            $role->forceDelete(); // Permanently delete
            Alert::toast('Role Permanently Deleted Successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to permanently delete role: ' . $e->getMessage(), 'error');
        }

        return redirect()->route('roles.index');
    }

    public function addPermissionToRole($roleId)
    {
        try {
            $permissions = Permission::all();
            $role = Role::findOrFail($roleId);
            $rolePermissions = DB::table('role_has_permissions')
                ->where('role_has_permissions.role_id', $role->id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();

            return view('role-permission.role.add-permissions', [
                'role' => $role,
                'permissions' => $permissions,
                'rolePermissions' => $rolePermissions
            ]);
        } catch (\Exception $e) {
            Alert::toast('Failed to load permissions for the role: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        try {
            $role = Role::findOrFail($roleId);
            $role->syncPermissions($request->permission);
            Alert::toast('Permissions added to role successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to add permissions to role: ' . $e->getMessage(), 'error');
        }

        return redirect()->back();
    }
}
