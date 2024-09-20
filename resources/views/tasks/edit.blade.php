@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <h1 class="mb-4">Edit Task</h1>

    <!-- Edit Task Form -->
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" id="completed" name="completed" class="form-check-input" {{ old('completed', $task->completed) ? 'checked' : '' }}>
            <label for="completed" class="form-check-label">Completed</label>
        </div>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
@endsection
