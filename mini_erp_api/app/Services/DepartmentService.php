<?php

namespace App\Services;

use App\Models\Department;
use App\Models\User;
use App\Services\LogService;

class DepartmentService
{
    public function __construct(
        protected LogService $logService
    ) {}
    /**
     * Departman listesi
     */
    public function list()
    {
        return Department::with('users')
            ->latest()
            ->paginate(10);
    }

    /**
     * Departman oluştur
     */
    public function create(array $data): Department
    {
        return Department::create([
            'name' => $data['name'],
        ]);
    }

    /**
     * Departman güncelle
     */
    public function update(Department $department, array $data): Department
    {
        $department->update($data);

        return $department->fresh();
    }

    /**
     * Departman sil (soft delete önerilir)
     */
    public function delete(Department $department): void
    {
        $department->delete();
    }

    /**
     * Departmana kullanıcı ata
     */
    public function assignUser(Department $department, User $user): void
    {
        if ($department->users()->where('user_id', $user->id)->exists()) {
            return;
        }

        $department->users()->attach($user->id);
        $this->logService->log(
            'department.user_assigned',
            $department,
            [
                'user_id' => $user->id,
            ]
        );
    }

    /**
     * Departmandan kullanıcı çıkar
     */
    public function removeUser(Department $department, User $user): void
    {
        $department->users()->detach($user->id);

        $this->logService->log(
            'department.user_removed',
            $department,
            [
                'user_id' => $user->id,
            ]
        );
    }
}
