<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
class DepartmentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Department $department): bool
    {
        if ($user->isAdmin()) return true;

        return $user->departments->contains($department->id);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Department $department): bool
    {
        return $user->isAdmin()
            || ($department->manager_id !== null && $department->manager_id === $user->id);
    }

    public function delete(User $user, Department $department): bool
    {
        return $user->isAdmin();
    }

    public function assignUser(User $user, Department $department): bool
    {
        return $this->update($user, $department);
    }

    public function removeUser(User $user, Department $department): bool
    {
        return $this->update($user, $department);
    }
}

