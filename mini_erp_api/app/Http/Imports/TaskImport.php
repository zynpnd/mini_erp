<?php

namespace App\Imports;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TaskImport implements ToCollection
{
    protected User $user;

    public function __construct(int $userId)
    {
        $this->user = User::findOrFail($userId);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            if ($index === 0) continue; // header

            Task::create([
                'title' => $row[0],
                'description' => $row[1] ?? null,
                'department_id' => $row[2],
                'assigned_user_id' => $row[3] ?? null,
                'status' => $row[4] ?? 'todo',
            ]);
        }
    }
}
