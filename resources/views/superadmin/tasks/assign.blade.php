@extends('layouts.app')

@section('content')
{{-- {{dd($users)}} --}}
<h1>Assign Users to Task: {{ $task->title }}</h1>

<form action="{{ route('tasks.assignUsers', $task->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="users" class="form-label">Select Users</label>
        <select name="users[]" id="users" class="form-control" multiple>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    @if($task->users->contains($user->id)) selected @endif>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Assign</button>
</form>
@endsection
