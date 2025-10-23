<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    
    // Show list + search + filter
    public function index(Request $request)
    {
        $query = Task::with('category')->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $tasks = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query'); // get search text from form input
        $tasks = Task::where('title', 'like', "%{$query}%")
                 ->orWhere('description', 'like', "%{$query}%")
                 ->get();

        return view('tasks.search', compact('tasks', 'query'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    // Save new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'due_date' => 'nullable|date',
            'is_completed' => 'nullable|boolean',
        ]);

        Task::create([
            'title' => $request->title,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'due_date' => $request->due_date,
            'category_id' => $request->category_id,
            'due_date' => $request->due_date,
            'is_completed' => false,
            // 'title' => $validated['title'],
            // 'description' => $validated['description'] ?? null,
            // 'category_id' => $validated['category_id'] ?? null,
            // 'due_date' => $validated['due_date'] ?? null,
            // 'is_completed' => $request->has('is_completed'),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    // Show edit form
    public function edit(Task $task)
    {
        // $this->authorize('update', $task); // Optional, if you use policies
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    // Update existing task
    public function update(Request $request, Task $task)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'nullable|exists:categories,id',
        'due_date' => 'nullable|date',
        'is_completed' => 'nullable|boolean',
    ]);

    $task->update([
        'title' => $validated['title'],
        'description' => $validated['description'] ?? null,
        'category_id' => $validated['category_id'] ?? null,
        'due_date' => $validated['due_date'] ?? null,
        'is_completed' => $request->has('is_completed'),
    ]);

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
}


    // Delete a task
    public function destroy(Task $task)
    {
        // $this->authorize('delete', $task); // Optional
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function toggleComplete(Task $task)
    {
    // Make sure only the owner can toggle
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

            $task->is_completed = !$task->is_completed;
            $task->save();

            return redirect()->route('tasks.index')->with('success', 'Task status updated.');
    }

  public function calendar(Request $request)
{
    $month = $request->input('month');
    $queryDate = $month ? Carbon::parse($month) : now();

    $tasks =Task::whereMonth('due_date', $queryDate->month)
        ->whereYear('due_date', $queryDate->year)
        ->where('user_id', auth()->id())
        ->get();

    return view('tasks.calendar', compact('tasks'));
}




}
