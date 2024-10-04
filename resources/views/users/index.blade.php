@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="row mb-3">
        <div class="col-md-6">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
        </div>
        <div class="col-md-6 text-md-end"> <!-- Aligns the dropdown and button to the right on larger screens -->
            <form method="GET" action="{{ route('users.index') }}" class="d-inline">
                <select name="role" class="form-select d-inline-block me-2" onchange="this.form.submit()" style="width: auto;">
                    <option value="">All Roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset Filter</a>
            </form>
        </div>
    </div>


    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Assign to Roles</th>
                <th>Assign to Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->roles->isNotEmpty())
                            <ul>
                                @foreach($user->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span>No roles assigned</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $permissions = $user->getAllPermissions();
                        @endphp
                        @if($permissions->isNotEmpty())
                            <ul>
                                @foreach($permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span>No permissions assigned</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('edit.roles', $user->id) }}" class="btn btn-info btn-sm">Assign Roles</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>


    </table>
</div>
@endsection
