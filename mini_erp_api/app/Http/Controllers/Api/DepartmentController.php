<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{

    public function __construct(
        protected DepartmentService $departmentService
    ) {}

    /**
     * Departman listesi
     */
    public function index()
    {
        $this->authorize('viewAny', Department::class);

        $departments = $this->departmentService->list();

        return apiSuccess($departments);
    }

    /**
     * Departman oluştur
     */
    public function store(StoreDepartmentRequest $request)
    {
        $this->authorize('create', Department::class);

        $department = $this->departmentService->create($request->validated());

        return apiSuccess($department, 'Departman oluşturuldu');
    }

    /**
     * Departman göster
     */
    public function show(Department $department)
    {
        $this->authorize('view', $department);

        return apiSuccess($department->load('users'));
    }

    /**
     * Departman güncelle
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->authorize('update', $department);

        $updated = $this->departmentService->update(
            $department,
            $request->validated()
        );

        return apiSuccess($updated, 'Departman güncellendi');
    }

    /**
     * Departman sil
     */
    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);

        $this->departmentService->delete($department);

        return apiSuccess(null, 'Departman silindi');
    }
}
