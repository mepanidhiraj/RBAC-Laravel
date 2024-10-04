@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Roles to {{ $user->name }}</h1>

    <form action="{{ route('update.roles', $user->id) }}" method="POST">
        @csrf
        <input type="hidden" name="userId" value="{{ $user->id }}">

        @foreach($roles as $role)
            <div>
                <label>
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                        {{ $user->hasRole($role) ? 'checked' : '' }}>
                    {{ $role->name }}
                </label>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Update Roles</button>
    </form>



    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</div>
@endsection
