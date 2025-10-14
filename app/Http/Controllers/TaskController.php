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

        // Start building the query for the authenticated user
        $tasks = Task::where('user_id', auth()->id());

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

        // Create a new task for the authenticated user
        Task::create([
            'title' => $request->title,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        // Find the task by its ID and ensure it belongs to the authenticated user
        $task = Task::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    
        // Check if this is a toggle request (only is_completed is provided)
        if ($request->has('is_completed') && !$request->has('title')) {
            // Toggle completion status
            $task->update([
                'is_completed' => $request->input('is_completed') === '1' || $request->input('is_completed') === 1
            ]);
        } else {
            // Full update with validation
            $request->validate([
                'title' => 'required|string|max:255',
                'is_completed' => 'required|in:0,1'
            ]);
            
            $task->update([
                'title' => $request->title,
                'is_completed' => $request->input('is_completed') === '1' || $request->input('is_completed') === 1
            ]);
        }
    
        // Redirect back to the task list
        return redirect()->route('tasks.index');
    }



    public function destroy(Task $task)
    {
        // Delete the task
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
