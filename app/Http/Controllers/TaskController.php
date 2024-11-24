<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('deadline')->get();
        return view('superadmin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $managers = User::where('role_id', Role::where('name', 'manager')->first()->id)->get();
        // dd($managers);
        return view('superadmin.tasks.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'manager_id' => 'required|exists:users,id',
        ]);

        Task::create($request->only('title', 'description', 'deadline', 'manager_id'));

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $managers = User::where('role_id', Role::where('name', 'manager')->first()->id)->get();
        return view('superadmin.tasks.edit', compact('task', 'managers'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'manager_id' => 'required|exists:users,id',
        ]);

        $task->update($validated);

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
        // dd("hi");
        $request->validate([
            'comment' => 'required|string',
        ]);


        $taskUser = TaskUser::where('task_id', $task->id)
            ->where('user_id', Auth::id())
            ->first();
        // dd($taskUser);

        if ($taskUser) {
            $taskUser->update(['comments' => $request->comment]);
        }
        return back()->with('success', 'Comment added successfully.');
    }
}
