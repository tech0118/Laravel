@extends('layouts.app')

@section('content')
<h1>Assign Tasks to {{ $user->name }}</h1>

<form action="{{ route('superadmin.users.assignTask', $user->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="tasks" class="form-label">Select Tasks</label>
        <select name="task_ids[]" id="tasks" class="form-control" multiple>
            @foreach($tasks as $task)
                <option value="{{ $task->id }}"
                        {{ in_array($task->id, $assignedTaskIds) ? 'selected' : '' }}>
                    {{ $task->title }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Assign Tasks</button>
    <a href="{{ route('superadmin.users.list') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
