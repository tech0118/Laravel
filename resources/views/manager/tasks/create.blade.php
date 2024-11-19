@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Task</h1>

    <form action="{{ route('manager.tasks.store') }}" method="POST">
        @csrf

        <!-- Task Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <!-- Task Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <!-- Deadline -->
        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline') }}" required>
        </div>

        <!-- Assign to User(s) -->
        <div class="mb-3">
            <label for="users" class="form-label">Assign to User(s)</label>
            <select name="user_ids[]" id="users" class="form-control" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Create Task</button>
            <a href="{{ route('manager.tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
