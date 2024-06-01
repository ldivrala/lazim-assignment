<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// API
Route::get('api/tasks', [TaskController::class, 'index'])->name('api.tasks.index');
Route::get('api/tasks/{slug}', [TaskController::class, 'show'])->name('api.tasks.show');
Route::post('api/tasks', [TaskController::class, 'store'])->name('api.tasks.store');
Route::put('api/tasks/{slug}', [TaskController::class, 'update'])->name('api.tasks.update');

// Web Routes
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::get('tasks/{slug}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::delete('tasks/{slug}', [TaskController::class, 'destroy'])->name('tasks.destroy');

