<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request){
        return Task::with(['department', 'assignee'])
            ->where(function ($q) use ($request) {
                if (!$request->user()->isAdmin()) {
                    $q->where('assigned_to', $request->user()->id);
                }
            })
            ->latest()
            ->paginate(10);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'department_id' => 'required|exists:departments,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        return Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'department_id' => $request->department_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => $request->user()->id,
        ]);
    }

    public function update(Task $task, Request $request){
        // Kullanıcı sadece kendi görevini güncelleyebilir
        if (!$request->user()->isAdmin() && $task->assigned_to !== $request->user()->id) {
            abort(403);
        }

        $task->update($request->only('status', 'title', 'description'));
        return $task;
    }
}
