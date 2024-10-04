<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user->load('roles.permissions');

        // dd($user);

        if (!$this->hasPermission($user, $permission)) {
            // return response()->json(['message' => 'Forbidden'], 403);
            return redirect()->route('errors.forbidden');
        }

        return $next($request);
    }

    private function hasPermission($user, $permission)
    {
        foreach ($user->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }

        return false;
    }
}
