<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $users = User::with('roles.permissions')->get();

        $roleName = $request->input('role');

        $users = User::whereNull('deleted_at')->with('roles.permissions')
        ->when($roleName, fn($query) => $query->withRole($roleName))
        ->get();

        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));

    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('User created: ' . $user->name);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('User updated: ' . $user->name);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('User deleted: ' . $user->name);

        $user->deleted_at = now();
        $user->save();
        // $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function assignRoleToUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $role = $request->input('role');

        $user->assignRole($role);

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('Role assigned to user: ' . $user->name);

        return redirect()->route('users.index')->with('success', 'Role assigned successfully!');
    }

    public function assignRolesToUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $roles = $request->input('roles', []);

        $user->syncRoles($roles);

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('Roles updated for user: ' . $user->name);

        return redirect()->route('users.index')->with('success', 'Roles assigned successfully!');
    }

    public function editRoles(User $user)
    {
        $roles = Role::all();
        return view('users.edit-roles', compact('user', 'roles'));
    }

    public function updateRoles(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::findOrFail($request->userId);
        $roleIds = $request->input('roles', []);

        $roles = Role::whereIn('id', $roleIds)->pluck('name')->toArray();

        $user->syncRoles($roles);

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('Roles assigned to user: ' . $user->name);

        return redirect()->route('users.index')->with('success', 'Roles assigned successfully!');
    }
}
