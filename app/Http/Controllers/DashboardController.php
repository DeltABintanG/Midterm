<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // current logged-in user

    $totalTasks = Task::where('user_id', $userId)->count();
    $completedTasks = Task::where('user_id', $userId)->where('is_completed', true)->count();
    $pendingTasks = Task::where('user_id', $userId)->where('is_completed', false)->count();
    $tasks = Task::where('user_id', $userId)->get();

    return view('dashboard', compact('totalTasks', 'completedTasks', 'pendingTasks', 'tasks'));
    }
}
