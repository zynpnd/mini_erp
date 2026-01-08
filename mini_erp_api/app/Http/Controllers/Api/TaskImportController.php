<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Imports\TaskImport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskImportController extends Controller
{
    use AuthorizesRequests;

     public function import(Request $request)
    {
        $this->authorize('create', \App\Models\Task::class);

        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new TaskImport(auth()->user()), $request->file('file'));

        return response()->json([
            'message' => 'Görevler başarıyla içe aktarıldı'
        ]);
    }
}
