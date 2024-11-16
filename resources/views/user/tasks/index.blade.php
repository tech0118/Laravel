@extends('layouts.app')

@section('content')
<h1>My Tasks</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->pivot->status }}</td>
                <td>
                    <a href="{{ route('user.tasks.show', $task->id) }}" class="btn btn-info">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
