@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Role List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Add New Role</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Permissions</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @if($role->permissions->isNotEmpty())
                            <ul>
                                @foreach($role->permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span>No permissions assigned</span>
                        @endif
                    </td>

                    <td>{{ $role->created_at }}</td>
                    <td>{{ $role->updated_at }}</td>
                    <td>
                        <a href="{{ route('roles.addPermissions', $role->id) }}" class="btn btn-info">Add / Edit Role Permissions</a>

                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Edit</a>

                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this role?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
