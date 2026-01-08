<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Task;
use App\Policies\ActivityLogPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class => TaskPolicy::class,
        Department::class => DepartmentPolicy::class,
        ActivityLog::class => ActivityLogPolicy::class,
    ];

    public function boot(): void
    {
          $this->registerPolicies();
    }
}
