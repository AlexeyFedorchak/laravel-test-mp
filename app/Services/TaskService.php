<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function createTask($data)
    {
        return Auth::user()->tasks()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'completed' => $data['completed'] ?? false,
        ]);
    }

    public function updateTask(Task $task, $data): Task
    {
        $task->update([
            'title' => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'completed' => $data['completed'] ?? $task->completed,
        ]);

        return $task;
    }

    public function deleteTask($id)
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->delete();
    }

    public function getAllTasks()
    {
        return Auth::user()->tasks()->get();
    }
}
