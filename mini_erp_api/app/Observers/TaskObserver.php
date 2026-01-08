<?php

namespace App\Observers;

use App\Models\Task;
use App\Services\LogService;

class TaskObserver
{
    public function __construct(
        protected LogService $logService
    ) {}

    public function created(Task $task): void
    {
        $this->logService->log(
            'task.create',
            $task,
            ['data' => $task->toArray()]
        );
    }

    public function updated(Task $task): void
    {
        $changes = $task->getChanges();
        $original = $task->getOriginal();

        $this->logService->log(
            'task.update',
            $task,
            [
                'old' => array_intersect_key($original, $changes),
                'new' => $changes,
            ]
        );
    }

    public function deleted(Task $task): void
    {
        $this->logService->log(
            'task.delete',
            $task,
            ['data' => $task->toArray()]
        );
    }
}
