@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Permissions to Role: {{ $role->name }}</h2>

        <form action="{{ route('roles.addPermissions', $role->id) }}" method="POST">
            @csrf
            @foreach ($permissions as $permission)
                <div>
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                        {{ $role->permissions && $role->permissions->contains($permission) ? 'checked' : '' }}>
                    {{ $permission->name }}
                </div>
            @endforeach


            <button type="submit" class="btn btn-primary">Save Permissions</button>
        </form>
    </div>
@endsection
