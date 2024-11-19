@extends('layouts.app')

@section('content')
<h1>Assign Task: {{ $task->title }}</h1>

<form action="{{ route('manager.tasks.assign', $task->id) }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="users" class="form-label">Assign to Users</label>
        <select name="user_ids[]" id="users" class="form-control" multiple>
            @foreach($users as $user)
                <option value="{{ $user->id }}"
                    {{ in_array($user->id, $assignedUserIds) ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Assign</button>
</form>
@endsection
