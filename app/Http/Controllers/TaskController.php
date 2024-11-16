<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('superadmin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('superadmin.tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Task::create($request->only('title', 'description'));

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('superadmin.tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $task->update($request->only('title', 'description'));

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function assign(Task $task)
    {
        $users = User::where('role', 2)->get();
        return view('superadmin.tasks.assign', compact('task', 'users'));
    }

    public function assignUsers(Request $request, Task $task)
    {
        $task->users()->sync($request->users);
        return redirect()->route('tasks.index')->with('success', 'Users assigned successfully.');
    }

    public function storeComment(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $task->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }
}
