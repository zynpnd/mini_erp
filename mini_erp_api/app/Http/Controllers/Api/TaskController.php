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

        $user = $request->user();

        return Task::with(['department', 'assignee'])
            ->where(function ($q) use ($user) {

                if ($user->isAdmin()) {
                    return;
                }

                $q->where('assigned_to', $user->id)
                ->orWhereHas('department', function ($dq) use ($user) {
                    $dq->where('manager_id', $user->id);
                });
            })
            ->latest()
            ->paginate(10);
    }


    /**
     * Task oluşturma
     * - Sadece Admin
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $this->authorize('create', [Task::class, $data]);

        // Atanan kullanıcı bu departmanda mı?
        $userInDepartment = \App\Models\User::find($data['assigned_to'])
            ->departments()
            ->where('departments.id', $data['department_id'])
            ->exists();

        if (! $userInDepartment) {
            return response()->json([
                'message' => 'Kullanıcı bu departmana ait değil'
            ], 422);
        }

        return Task::create([
            ...$data,
            'created_by' => $request->user()->id,
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

            $data = $request->validate([
                'status' => 'required|in:todo,doing,done',
            ]);

            $task->update([
                'status' => $data['status'],
            ]);

            return response()->json([
                'message' => 'Görev durumu güncellendi',
                'task' => $task
            ]);
        }

}
