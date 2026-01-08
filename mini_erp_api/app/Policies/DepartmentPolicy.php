<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;

class DepartmentPolicy
{
    /**
     * Departman listeleme
     */
    public function viewAny(User $user): bool
    {
        // Admin her şeyi görür
        if ($user->isAdmin()) return true;

        // Kullanıcı bağlı olduğu departmanları görür
        return $user->departments()->exists();
    }

    /**
     * Tek departman görme
     */
    public function view(User $user, Department $department): bool
    {
        if ($user->isAdmin()) return true;

        return $user->departments()
            ->where('departments.id', $department->id)
            ->exists();
    }

    /**
     * Departman oluşturma
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Güncelleme
     */
    public function update(User $user, Department $department): bool
    {
        if ($user->isAdmin()) return true;

        // Departman yöneticisi güncelleyebilir
        return $department->manager_id === $user->id;
    }

    /**
     * Silme
     */
    public function delete(User $user, Department $department): bool
    {
        return $user->isAdmin();
    }

    /**
     * Departmana kullanıcı ekleme / çıkarma
     */
    public function manageUsers(User $user, Department $department): bool
    {
        if ($user->isAdmin()) return true;

        return $department->manager_id === $user->id;
    }

}
