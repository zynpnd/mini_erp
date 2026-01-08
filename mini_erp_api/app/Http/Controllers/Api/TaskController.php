<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    /**
     * Task listesi
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->listForUser($request->user());

        return apiSuccess($tasks);
    }

    /**
     * Task oluştur
     */
    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);

        $task = $this->taskService->create($request->validated());

        return apiSuccess($task, 'Görev oluşturuldu');
    }

    /**
     * Task güncelle
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $updatedTask = $this->taskService->update($task, $request->validated());

        return apiSuccess($updatedTask, 'Görev güncellendi');
    }

    /**
     * Task status değiştir
     */
    public function updateStatus(UpdateTaskStatusRequest $request, Task $task)
    {
        $this->authorize('updateStatus', $task);

        $updatedTask = $this->taskService->updateStatus(
            $task,
            $request->validated()['status']
        );

        return apiSuccess($updatedTask, 'Görev durumu güncellendi');
    }
}
