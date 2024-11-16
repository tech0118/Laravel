@extends('layouts.app')

@section('content')
    <h1>Users List</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('superadmin.users.assignTaskForm', $user->id) }}" class="btn btn-primary">
                            Assign Task
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
