<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks;
        // dd($tasks);
        return view('user.tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $userTask = TaskUser::where('user_id', Auth::id())->where('task_id', $task->id)->first();
        $status = $userTask ? $userTask->status : 'Not Assigned';
        $comments = $task->comments()->with('user')->get();

        return view('user.tasks.show', compact('task', 'status', 'comments'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => ['required', 'in:Pending,Completed'],
        ]);
        TaskUser::where('user_id', Auth::id())->where('task_id', $task->id)->first()->update(['status' => $request->status]);

        return redirect()->route('user.tasks.show', $task->id)
            ->with('success', 'Task status updated successfully.');
    }
}
