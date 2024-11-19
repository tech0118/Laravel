@extends('layouts.app')

@section('content')
<h1>Edit Task</h1>

<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="5" required>{{ $task->description }}</textarea>
    </div>
    <div class="mb-3">
        <label for="deadline" class="form-label">Deadline</label>
        <input type="date" name="deadline" id="deadline" class="form-control" value="{{ $task->deadline }}" required>
    </div>
    <div class="mb-3">
        <label for="manager_id" class="form-label">Assigned Manager</label>
        <select name="manager_id" id="manager_id" class="form-control" required>
            <option value="" disabled>Select Manager</option>
            @foreach($managers as $manager)
                <option value="{{ $manager->id }}" {{ $task->manager_id == $manager->id ? 'selected' : '' }}>
                    {{ $manager->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
