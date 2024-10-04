@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Permission</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Permission</button>
        </form>
    </div>
@endsection
