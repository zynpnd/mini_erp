<?php

namespace App\Observers;

use App\Models\Department;
use App\Services\LogService;

class DepartmentObserver
{
    public function __construct(
        protected LogService $logService
    ) {}

    public function created(Department $department): void
    {
        $this->logService->log(
            'department.create',
            $department,
            ['data' => $department->toArray()]
        );
    }

    public function updated(Department $department): void
    {
        $changes = $department->getChanges();
        $original = $department->getOriginal();

        $this->logService->log(
            'department.update',
            $department,
            [
                'old' => array_intersect_key($original, $changes),
                'new' => $changes,
            ]
        );
    }

    public function deleted(Department $department): void
    {
        $this->logService->log(
            'department.delete',
            $department,
            ['data' => $department->toArray()]
        );
    }
}
