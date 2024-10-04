<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActivityLogController;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

use App\Http\MiddlewareApp\Http\Middleware\CheckPermission;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.index');
    } else {
        return redirect()->route('auth.login');
    }
});

//  Route::group(['middleware' => ['auth']], function () {
//     Route::get('/', function () {
//         return view('index');
//     })->middleware('check.permission:view-admin');
// });

Route::middleware(['check.permission:view-admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    });
});


Route::prefix('auth')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('auth.index');
    Route::post('login', [LoginController::class, 'login'])->name('auth.login');
    Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');
});


Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/{user}/edit-roles', [UserController::class, 'editRoles'])->name('edit.roles');
    Route::post('/{user}/update-roles', [UserController::class, 'updateRoles'])->name('update.roles');
});


Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('roles/{role}/add-permissions', [RoleController::class, 'addPermissionsToRole'])->name('roles.addPermissions');
    Route::post('roles/{role}/add-permissions', [RoleController::class, 'updatePermissions']);

});


Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});


Route::prefix('activity-log')->group(function () {
    Route::get('/', [ActivityLogController::class, 'index'])->name('activity_log.index');
});


Route::get('/forbidden', function () {
    return view('errors.forbidden');
})->name('errors.forbidden');
