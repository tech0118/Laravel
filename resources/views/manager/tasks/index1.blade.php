@extends('layouts.app')

@section('content')
<h1>Task Management</h1>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Task Name</th>
            <th>Description</th>
            <th>Deadline</th>
            <th>Assigned Users and Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($tasks as $task)
            <tr>
                <td>{{ $task['id'] }}</td>
                <td>{{ $task['name'] }}</td>
                <td>{!! $task['description'] !!}</td>
                <td>{{ \Carbon\Carbon::parse($task['deadline'])->format('d M Y, h:i A') }}</td>
                <td>
                    @if (!empty($task['users']))
                        <ul>
                            @foreach ($task['users'] as $user)
                                <li>
                                    {{ $user['name'] }} ({{ $user['email'] }}) -
                                    <strong>Status:</strong> {{ ucfirst($user['pivot']['status']) }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        No users assigned
                    @endif
                </td>
                <td>
                    @if (!empty($task['users']))
                        @foreach ($task['users'] as $user)
                            <form action="{{ route('manager.tasks.updateUserStatus', ['task' => $task['id'], 'user' => $user['id']]) }}" method="POST" class="mb-2">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <strong>{{ $user['name'] }}:</strong>
                                </div>
                                <select name="status" class="form-control mb-1">
                                    <option value="pending" {{ $user['pivot']['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ $user['pivot']['status'] === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                            </form>
                        @endforeach
                    @else
                        No actions available
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No tasks available</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
