<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserTaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Register Routes
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware(['auth', 'role:1'])->prefix('superadmin')->name('tasks.')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('destroy');
    Route::post('/tasks/{task}/assign', [TaskController::class, 'assignUsers'])->name('assignUsers');
});
Route::get('/superadmin/users', [SuperAdminController::class, 'usersList'])->name('superadmin.users.list');
Route::get('/superadmin/users/{user}/assign-task', [SuperAdminController::class, 'assignTaskForm'])->name('superadmin.users.assignTaskForm');
Route::post('/superadmin/users/{user}/assign-task', [SuperAdminController::class, 'assignTask'])->name('superadmin.users.assignTask');
Route::patch('/tasks/{task}/status', [UserTaskController::class, 'updateStatus'])->name('user.tasks.updateStatus');



Route::middleware(['auth', 'role:2'])->prefix('user')->name('user.tasks.')->group(function () {
    Route::get('/tasks', [UserTaskController::class, 'index'])->name('index');
    Route::get('/tasks/{task}', [UserTaskController::class, 'show'])->name('show');
    Route::post('tasks/{task}/comment', [TaskController::class, 'storeComment'])->name('comment');
});
// Logout Route
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');