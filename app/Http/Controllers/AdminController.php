<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $usersCount = User::count();
            $rolesCount = Role::count();
            $permissionsCount = Permission::count();

            return view('admin.index', compact('usersCount', 'rolesCount', 'permissionsCount'));
        } else {
            return redirect()->route('auth.login');
        }
    }

    public function users()
    {
        $users = User::with('roles')->orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function roles()
    {
        $roles = Role::orderBy('name')->get();
        return view('roles.index', compact('roles'));
    }

    public function permissions()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('permissions.index', compact('permissions'));
    }

    public function activity_logs()
    {
        $activities = Activity::with('causer')->orderBy('created_at', 'desc')->paginate(10);

        return view('activity_log.index', compact('activities'));
    }
}
