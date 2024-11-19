<?php

namespace App\Http\Controllers;

use App\Mail\TaskAssignedMail;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ManagerTaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('manager_id', Auth::id())->with('users')->get();
        return view('manager.tasks.index', compact('tasks'));
    }

    // Show the form for creating a new task
    public function create()
    {
        $users = User::whereNotIn('role_id', [1, 3])->get();

        return view('manager.tasks.create', compact('users'));
    }

    // Store a newly created task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'manager_id' => Auth::id(),
        ]);
        // dd($request->user_ids);
        $task->users()->sync($request->user_ids ?? []);

        // dd($task->users);
        Mail::to(Auth::user()->email)
            ->send(new TaskAssignedMail($task, 'Manager'));
        foreach ($task->users as $user) {
            Mail::to($user->email)
                ->send(new TaskAssignedMail($task, 'User'));
        }

        return redirect()->route('manager.tasks.index')->with('success', 'Task created successfully.');
    }

    // Show the form to edit a task
    public function edit(Task $task)
    {
        if (Auth::id() !== $task->manager_id) {
            abort(403, 'You are not authorized to edit this task.');
        }
        $users = User::whereNotIn('role_id', [1, 3])->get();
        // dd($users);
        return view('manager.tasks.edit', compact('task', 'users'));
    }

    // Update a task
    public function update(Request $request, Task $task)
    {
        if (Auth::id() !== $task->manager_id) {
            abort(403, 'You are not authorized to edit this task.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $task->update($validated);
        $task->users()->sync($validated['user_ids'] ?? []);


        return redirect()->route('manager.tasks.index')->with('success', 'Task updated successfully.');
    }

    // Show form to assign a task to users
    public function assignForm(Task $task)
    {
        if (Auth::id() !== $task->manager_id) {
            abort(403, 'You are not authorized to edit this task.');
        }

        $users = User::where('role_id', 2)->get(); // Assuming 3 is the role ID for regular users
        $assignedUserIds = $task->users->pluck('id')->toArray();

        return view('manager.tasks.assign', compact('task', 'users', 'assignedUserIds'));
    }

    // Assign a task to users
    public function assign(Request $request, Task $task)
    {
        if (Auth::id() !== $task->manager_id) {
            abort(403, 'You are not authorized to edit this task.');
        }

        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $task->users()->sync($validated['user_ids']);

        return redirect()->route('manager.tasks.index')->with('success', 'Task assigned successfully.');
    }
}
