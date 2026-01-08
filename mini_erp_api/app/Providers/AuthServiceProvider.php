<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Task;
use App\Policies\DepartmentPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class => TaskPolicy::class,
        Department::class => DepartmentPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
