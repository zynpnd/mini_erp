<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\DepartmentUserController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskImportController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // ---------------- TASKS ----------------
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);

    Route::middleware('admin')->group(function () {
        Route::post('/tasks', [TaskController::class, 'store']);
        Route::post('/tasks/import', [TaskImportController::class, 'import']);
    });

    // ---------------- DEPARTMENTS ----------------
    Route::apiResource('departments', DepartmentController::class);

    Route::post(
        '/departments/{department}/users',
        [DepartmentUserController::class, 'store']
    );

    Route::delete(
        '/departments/{department}/users/{user}',
        [DepartmentUserController::class, 'destroy']
    );
});
