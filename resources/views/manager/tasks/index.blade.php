@extends('layouts.app')

@section('content')
<h1>My Tasks</h1>

<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Deadline</th>
            <th>Assigned Users</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->deadline }}</td>
            <td>
                @foreach($task->users as $user)
                    {{ $user->name }},
                @endforeach
            </td>
            <td>
                <a href="{{ route('manager.tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <a href="{{ route('user.tasks.show', $task->id) }}" class="btn btn-primary btn-sm">Show</a>
                <a href="{{ route('manager.tasks.assignForm', $task->id) }}" class="btn btn-secondary btn-sm">Assign</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
