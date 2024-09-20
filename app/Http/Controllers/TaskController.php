<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;

        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = $this->taskService->getAllTasks();

        return view('dashboard', ['tasks' => $tasks]);
    }

    public function store(StoreTaskRequest $request)
    {
        return new TaskResource(
            $this->taskService->createTask($request->validated())
        );
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        $data['completed'] = $request->has('completed') ? 1 : 0;

        $task = $this->taskService->updateTask($task, $data);

        return new TaskResource($task);
    }

    public function destroy($id)
    {
        $this->taskService->deleteTask($id);

        return response()->json(['success' => true]);
    }
}

