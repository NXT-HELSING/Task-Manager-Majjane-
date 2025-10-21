<?php
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Livewire\TaskBoard;
use App\Livewire\QuickAddTask;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    
    Route::resource('projects', ProjectController::class);
});
Route::middleware(['auth'])->group(function () {
    // Route for task board view of a project
    Route::get('projects/{project}/board', TaskBoard::class)->name('projects.board');

    // Route for quick task creation (optional, if used standalone)
    Route::get('projects/{project}/tasks/quick-add', QuickAddTask::class)->name('projects.tasks.quick-add');
});

require __DIR__.'/auth.php';
