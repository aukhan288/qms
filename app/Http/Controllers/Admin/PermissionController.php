<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function permissions()
    {
        $permissions = Permission::all();
        return view('admin.permissions.list', compact('permissions'));
    }

    public function showPermissionForm($id = null)
    {
        $permission = $id ? Permission::findOrFail($id) : null;
        return view('admin.permissions.form', compact('permission'));
    }

    public function storeOrUpdate(Request $request, $id = null)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $id]);

        $data = ['name' => $request->name];

        if ($id) {
            Permission::where('id', $id)->update($data);
            $message = 'Permission updated successfully.';
        } else {
            Permission::create($data);
            $message = 'Permission created successfully.';
        }

        return redirect()->route('permissions.index')->with('success', $message);
    }

    public function deletePermission($id)
    {
        Permission::findOrFail($id)->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted.');
    }
}
