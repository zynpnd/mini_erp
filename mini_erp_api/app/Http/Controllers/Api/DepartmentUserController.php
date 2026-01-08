<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DepartmentUserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Departmana kullanıcı ekle
     */
    public function store(Request $request, Department $department)
    {
        $this->authorize('manageUsers', $department);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Zaten ekli mi?
        if ($department->users()->where('user_id', $data['user_id'])->exists()) {
            return response()->json([
                'message' => 'Kullanıcı zaten bu departmanda'
            ], 422);
        }

        $department->users()->attach($data['user_id']);

        return response()->json([
            'message' => 'Kullanıcı departmana eklendi'
        ]);
    }

    /**
     * Departmandan kullanıcı çıkar
     */
    public function destroy(Department $department, User $user)
    {
        $this->authorize('manageUsers', $department);

        $department->users()->detach($user->id);

        return response()->json([
            'message' => 'Kullanıcı departmandan çıkarıldı'
        ]);
    }
}
