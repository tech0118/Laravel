@extends('layouts.app')

@section('content')
    <h1>Task Details</h1>

    <div class="card">
        <div class="card-header">
            <h3>{{ $task->title }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong></p>
            <p>{{ $task->description }}</p>
            <p><strong>Status:</strong> {{ $status }}</p>
        </div>
    </div>

    @if (Auth::user()->role_id == 3)
        <h3>Change Task Status</h3>
        <form action="{{ route('user.tasks.updateStatus', $task->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="status" class="form-label">Select New Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="Pending" {{ $status === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ $status === 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
    @endif


    <h3>Comments</h3>
    @if ($comments->isEmpty())
        <p>No comments added yet.</p>
    @else
        <ul>
            @foreach ($comments as $comment)
                <li>
                    <strong>{{ $comment->user->name }}:</strong>
                    {{ $comment->comment }}
                    <br>
                    <small>{{ $comment->created_at->format('d M Y, h:i A') }}</small>
                </li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('user.tasks.comment', $task->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="mb-3">
            <label for="comment" class="form-label">Add Comment</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Comment</button>
    </form>
@endsection
