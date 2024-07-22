<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create','store']]);
        $this->middleware('permission:update permission', ['only' => ['update','edit']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
        $this->middleware('permission:force delete permission', ['only' => ['forceDelete']]); // Assuming a separate permission for force delete
    }

    public function index()
    {
        $permissions = Permission::get();
        return view('role-permission.permission.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        return view('role-permission.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('status','Permission Created Successfully');
    }

    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('status','Permission Updated Successfully');
    }

    public function destroy($permissionId)
    {
        try {
        $permission = Permission::findOrFail($permissionId);
        $permission->delete();
        Alert::toast('Permission Deleted Successfully', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to Delete Permission: ' . $e->getMessage(), 'error');
        }

        return redirect('permissions');
    }

    public function forceDelete($permissionId)
    {
        $permission = Permission::withTrashed()->findOrFail($permissionId);
        $permission->forceDelete(); // Permanently delete
        
        return redirect()->route('permissions.index')->with('status', 'Permission Permanently Deleted Successfully');
    }

    public function restoreAll()
    {
        $deletedPermission = Permission::onlyTrashed()->get();
        
        return view('role-permission.permissions.restore', compact('deletedPermission'));
 
    }

    public function restore($permissionId)
    {
        $permission = Permission::withTrashed()->findOrFail($permissionId);
        $permission->restore();

        return redirect()->route('permissions.index')->with('status', 'Permission Restored Successfully');
    }
}