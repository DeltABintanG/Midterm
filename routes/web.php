<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

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

Route::get('/tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');

// Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
// Route::resource('tasks', TaskController::class);
// Route::middleware(['auth'])->group(function () {
//     Route::resource('tasks', TaskController::class);    
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tasks', TaskController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
});    


Route::resource('tasks', TaskController::class);
Route::resource('categories', CategoryController::class);

Route::patch('/tasks/{task}/toggle', [\App\Http\Controllers\TaskController::class, 'toggleComplete'])
    ->name('tasks.toggle');
    

require __DIR__.'/auth.php';
