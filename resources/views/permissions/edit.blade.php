@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Permission</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $permission->name) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Permission</button>
        </form>
    </div>
@endsection
