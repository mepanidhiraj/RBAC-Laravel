<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Models\Activity;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereNull('deleted_at')->orderBy('name', 'ASC')->get();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ]);

        $role = Role::create($request->all());

        activity()
            ->performedOn($role)
            ->causedBy(Auth::user())
            ->log('Role created: ' . $role->name);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update($request->all());

        activity()
            ->performedOn($role)
            ->causedBy(Auth::user())
            ->log('Role updated: ' . $role->name);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        activity()
            ->performedOn($role)
            ->causedBy(Auth::user())
            ->log('Role deleted: ' . $role->name);

            $role->deleted_at = now();
            $role->save();
            // $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    public function addPermissionsToRole($id) {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return view('roles.add-permissions', compact('role', 'permissions'));
    }

    public function updatePermissions(Request $request, $id) {
        $role = Role::findOrFail($id);
        $permissions = $request->input('permissions', []);

        $role->syncPermissions($permissions);

        activity()
            ->performedOn($role)
            ->causedBy(Auth::user())
            ->log('Permissions updated for role: ' . $role->name);

        return redirect()->route('roles.index')->with('success', 'Permissions updated successfully!');
    }
}
