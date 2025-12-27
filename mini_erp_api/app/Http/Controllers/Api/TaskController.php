<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Task listesi
     * - Admin: tüm task'ler
     * - User: sadece kendisine atanmış task'ler
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        return Task::with(['department', 'assignee'])
            ->when(
                !$request->user()->isAdmin(),
                fn ($q) => $q->where('assigned_to', $request->user()->id)
            )
            ->latest()
            ->paginate(10);
    }

    /**
     * Task oluşturma
     * - Sadece Admin
     */
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        return Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'department_id' => $validated['department_id'],
            'assigned_to' => $validated['assigned_to'],
            'created_by' => $request->user()->id,
            'status' => 'todo',
        ]);
    }

    /**
     * Task güncelleme
     * - Admin: her şeyi güncelleyebilir
     * - User: sadece kendi task'ini güncelleyebilir
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|in:todo,doing,done',
        ]);

        $task->update($validated);

        return $task;
    }
}
