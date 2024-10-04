@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <h1>Users: {{ $usersCount ?? 0 }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Roles</div>
                <div class="card-body">
                    <h1>Roles: {{ $rolesCount ?? 0 }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Permissions</div>
                <div class="card-body">
                    <h1>Permissions: {{ $permissionsCount ?? 0 }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
