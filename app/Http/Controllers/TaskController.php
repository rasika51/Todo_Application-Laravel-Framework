<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Get query parameters for filtering and searching
        $filter = $request->input('filter', 'all'); // Default to 'all'
        $search = $request->input('search', '');   // Default to an empty search

        // Start building the query
        $tasks = Task::query();

        // Apply search filter if a search term is provided
        if (!empty($search)) {
            $tasks->where('title', 'like', '%' . $search . '%');
        }

        // Apply completion status filter
        if ($filter === 'completed') {
            $tasks->where('is_completed', true);
        } elseif ($filter === 'pending') {
            $tasks->where('is_completed', false);
        }

        // Get the filtered tasks
        $tasks = $tasks->get();

        return view('tasks.index', compact('tasks', 'filter', 'search'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate(['title' => 'required|string|max:255']);

        // Create a new task
        Task::create($request->only('title'));

        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'is_completed' => 'nullable|boolean', // Optional field
        ]);

        // Update the title and completion status if provided
        $task->update($request->only(['title', 'is_completed']));

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        // Delete the task
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
