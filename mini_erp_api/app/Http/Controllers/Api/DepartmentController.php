<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Department::class);

        $query = Department::with(['manager']);

        if (! $request->user()->isAdmin()) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where('users.id', $request->user()->id);
            });
        }

        return $query->paginate(10);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Department::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'required|exists:users,id',
        ]);

        return Department::create($data);
    }

    public function show(Department $department)
    {
        $this->authorize('view', $department);

        return $department->load(['manager', 'users']);
    }

    public function update(Request $request, Department $department)
    {
        $this->authorize('update', $department);

        $department->update(
            $request->only('name', 'manager_id')
        );

        return $department;
    }

    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);

        $department->delete();

        return response()->noContent();
    }
}
