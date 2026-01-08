<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Services\DepartmentService;

class DepartmentUserController extends Controller
{
    public function __construct(
        protected DepartmentService $departmentService
    ) {}

    /**
     * Departmana kullanıcı ata
     */
    public function store(Department $department, User $user)
    {
        $this->authorize('assignUser', $department);

        $this->departmentService->assignUser($department, $user);

        return apiSuccess(null, 'Kullanıcı departmana atandı');
    }

    /**
     * Departmandan kullanıcı çıkar
     */
    public function destroy(Department $department, User $user)
    {
        $this->authorize('removeUser', $department);

        $this->departmentService->removeUser($department, $user);

        return apiSuccess(null, 'Kullanıcı departmandan çıkarıldı');
    }
}
