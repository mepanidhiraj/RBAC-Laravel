@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Activity Log</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Time</th>
                <th>Log</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->created_at }}</td>
                    <td>{{ $activity->description }}</td>
                    <td>{{ $activity->causer->name ?? 'System' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $activities->links() }}
</div>
@endsection
