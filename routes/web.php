<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Redirect root URL to projects.index if logged in
    if (auth()->check()) {
        return redirect()->route('projects.index');
    }
    // If not logged in, go to login page
    return redirect()->route('login');
});

// Optional: you can still keep dashboard route (but redirect it too)
Route::get('/dashboard', function () {
    return redirect()->route('projects.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Protected routes (need login)
Route::middleware(['auth'])->group(function () {
    // Project management (CRUD) - put resource routes inside auth middleware
    Route::resource('projects', ProjectController::class);

    // nested routes for tasks
    Route::get('projects/{project}/tasks/create', [TaskController::class, 'create'])->name('projects.tasks.create');
    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
