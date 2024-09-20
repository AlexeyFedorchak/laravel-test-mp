@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
    <h1 class="mb-4">Tasks</h1>

    <!-- Task Form -->
    <form id="task-form" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>

    <!-- Task Table -->
    <table id="task-list" class="table table-striped">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr data-id="{{ $task->id }}">
                <td class="task-title">{{ $task->title }}</td>
                <td class="task-description">{{ $task->description }}</td>
                <td>
                    <button class="btn btn-warning btn-sm toggle-complete">
                        {{ $task->completed ? 'Mark as Incomplete' : 'Mark as Complete' }}
                    </button>
                    <button class="btn btn-info btn-sm edit-task">Edit</button>
                    <button class="btn btn-danger btn-sm delete-task">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-task-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit-task-id" name="id">
                        <div class="mb-3">
                            <label for="edit-title" class="form-label">Title</label>
                            <input type="text" id="edit-title" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-description" class="form-label">Description</label>
                            <textarea id="edit-description" name="description" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
