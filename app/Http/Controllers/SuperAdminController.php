<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function usersList()
    {
        $users = User::where('role', 2)->get();
        return view('superadmin.users.list', compact('users'));
    }

    public function assignTaskForm(User $user)
    {
        $tasks = Task::all();
        $assignedTaskIds = $user->tasks->pluck('id')->toArray();

        return view('superadmin.users.assign_task', compact('user', 'tasks', 'assignedTaskIds'));
    }


    public function assignTask(Request $request, User $user)
    {
        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:tasks,id',
        ]);

        $user->tasks()->sync($request->task_ids);

        return redirect()->route('superadmin.users.list')->with('success', 'Tasks assigned successfully.');
    }
}
