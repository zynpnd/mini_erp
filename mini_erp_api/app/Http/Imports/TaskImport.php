<?php

namespace App\Imports;

use App\Models\Task;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TaskImport implements ToCollection, WithHeadingRow
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Task::create([
                'title' => $row['title'],
                'description' => $row['description'] ?? null,
                'status' => $row['status'] ?? 'todo',
                'assigned_to' => $row['assigned_to'] ?? null,
                'department_id' => $this->user->department_id,
                'created_by' => $this->user->id,
            ]);
        }
    }
}
