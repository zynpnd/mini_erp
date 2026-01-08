<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ImportTasksJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskImportController extends Controller
{

    public function import(Request $request)
    {
        $this->authorize('create', \App\Models\Task::class);

        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,csv'],
        ]);

        $path = $request->file('file')->store('imports');

        ImportTasksJob::dispatch($path, Auth::id());

        return apiSuccess(null, 'Görev import işlemi başlatıldı');
    }
}
