<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    /**
     * Kullanıcıya göre task listesi
     */
    public function listForUser(User $user)
    {
        if ($user->isAdmin()) {
            return Task::with(['department', 'assignedUser'])
                ->latest()
                ->paginate(10);
        }

        return Task::with(['department', 'assignedUser'])
            ->where('assigned_user_id', $user->id)
            ->latest()
            ->paginate(10);
    }

    /**
     * Task oluştur
     */
    public function create(array $data): Task
    {
        return Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'department_id' => $data['department_id'],
            'assigned_user_id' => $data['assigned_user_id'] ?? null,
            'status' => $data['status'] ?? 'todo',
            'due_date' => $data['due_date'] ?? null,
        ]);
    }

    /**
     * Task güncelle
     */
    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        return $task->fresh();
    }

    /**
     * Task status değiştir (workflow kapısı)
     */
    public function updateStatus(Task $task, string $status): Task
    {
        $task->update([
            'status' => $status,
        ]);

        return $task->fresh();
    }
}
