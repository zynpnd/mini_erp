<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Admin tüm task'leri görebilir
     * User sadece kendi task'lerini görebilir
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Admin her task'i görür
     * User sadece kendine atanmış task'i görür
     */
    public function view(User $user, Task $task): bool
    {
        return $user->is_admin || $task->user_id === $user->id;
    }

    /**
     * Sadece Admin task oluşturabilir
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Admin her task'i güncelleyebilir
     * User sadece kendi task'inin status'unu güncelleyebilir
     */
    public function update(User $user, Task $task): bool
    {
        return $user->is_admin || $task->user_id === $user->id;
    }

    /**
     * Şimdilik task silme yok
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->is_admin;
    }
}
