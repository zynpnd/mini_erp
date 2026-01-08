<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Listeleme
     */
    public function viewAny(User $user): bool
    {
        return true; // filtreyi controller'da yapacağız
    }

    public function create(User $user, array $data): bool
    {
        if ($user->isAdmin()) return true;

        // Departman yöneticisi mi?
        $departmentId = $data['department_id'] ?? null;

        if (! $departmentId) return false;

        return $user->departments()
            ->where('departments.id', $departmentId)
            ->where('departments.manager_id', $user->id)
            ->exists();
    }



    /**
     * Tek görev görme
     */
    public function view(User $user, Task $task): bool
    {
        if ($user->isAdmin()) return true;

        // Kullanıcı bu departmanda mı?
        $userInDepartment = $user->departments()
            ->where('departments.id', $task->department_id)
            ->exists();

        if (! $userInDepartment) return false;

        // Kendisine atanmışsa
        if ($task->assigned_to === $user->id) return true;

        // Departman yöneticisi ise
        return $task->department->manager_id === $user->id;
    }


    /**
     * Güncelleme
     */
    public function update(User $user, Task $task): bool
    {
        if ($user->isAdmin()) return true;

        $userInDepartment = $user->departments()
            ->where('departments.id', $task->department_id)
            ->exists();

        if (! $userInDepartment) return false;

        if ($task->assigned_to === $user->id) return true;

        return $task->department->manager_id === $user->id;
    }


    /**
     * Silme
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }
}
