@extends('layouts.app')

@section('content')
<h1>Todo List</h1>

<!-- Add New Task Form -->
<form action="{{ route('tasks.store') }}" method="POST" class="mb-4">
    @csrf
    <div class="input-group">
        <input type="text" name="title" class="form-control" placeholder="New Task" required>
        <button class="btn btn-success" type="submit">Add</button>
    </div>
</form>

<!-- Search Bar and Filter Dropdown (in same line) -->
<div class="d-flex mb-4 w-100 task-controls">
    <!-- Filter Dropdown -->
    <form action="{{ route('tasks.index') }}" method="GET" class="d-flex me-2 w-50">
        <select name="filter" class="form-select" onchange="this.form.submit()">
            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All Tasks</option>
            <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
        <input type="hidden" name="search" value="{{ request('search') }}">
    </form>

    <!-- Search Bar -->
    <form action="{{ route('tasks.index') }}" method="GET" class="d-flex w-50">
        <input type="text" name="search" class="form-control me-2" placeholder="Search tasks by title" value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>
</div>

<!-- Task List -->
<ul class="list-group">
    @forelse ($tasks as $task)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <!-- Checkbox to mark task as completed -->
                <input type="checkbox" 
                    {{ $task->is_completed ? 'checked' : '' }} 
                    onchange="document.getElementById('toggle-task-{{ $task->id }}').submit();">
                <form id="toggle-task-{{ $task->id }}" 
                    action="{{ route('tasks.update', $task->id) }}" 
                    method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="is_completed" value="{{ !$task->is_completed }}">
                </form>

                <!-- Task Title with Line-through for Completed Tasks -->
                <span class="{{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                    {{ $task->title }}
                </span>
            </div>
            <div>
                <!-- Edit Button -->
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <!-- Delete Button -->
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                </form>
            </div>
        </li>
    @empty
        <li class="list-group-item">No tasks found.</li>
    @endforelse
</ul>

@endsection

@section('styles')
<style>
    /* Custom styling for task controls (Search Bar + Filter Dropdown) */
    .task-controls .form-control,
    .task-controls .form-select {
        width: 100%;
    }

    .task-controls form {
        flex-grow: 1;
    }

    /* Ensure both forms share space equally */
    .task-controls .w-50 {
        flex: 1 1 50%;
    }

    .task-controls {
        width: 100%;
    }

    /* Additional styling for form buttons */
    .task-controls button {
        max-width: 120px;
    }

    /* Media Query for Small Screens (Mobile View) */
/* Media Query for Small Screens (Mobile View) */
@media (max-width: 767px) {
    .input-group {
        flex-direction: column; /* Stack input and button vertically */
        width: 100%; /* Full width for the group */
    }

    .input-group .form-control {
        width: 100%; /* Full width for input */
        margin-bottom: 10px; /* Space between input and button */
    }

    .input-group button,
    .btn {
        width: 100%; /* Full width for buttons */
    }

    .task-controls {
        flex-direction: column; /* Stack filter and search vertically */
        gap: 10px; /* Add spacing between the forms */
    }
}

/* Media Query for Larger Screens (Above 767px) */
@media (min-width: 768px) {
    .input-group {
        flex-direction: row; /* Input and button side by side */
    }

    .input-group .form-control {
        width: 80%; /* Input takes up 80% width */
    }

    .input-group button {
        width: 20%; /* Button takes up 20% width */
    }

    .btn {
        width: auto; /* Buttons adjust naturally */
    }

    .task-controls {
        flex-direction: row; /* Filter and search side by side */
    }
}

</style>
@endsection

@section('scripts')
<script>
    function submitTaskForm(taskId) {
        var form = document.getElementById('toggle-task-' + taskId);
        form.submit();
    }
</script>
@endsection
