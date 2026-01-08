<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskImportController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\DepartmentUserController;
use App\Http\Controllers\Api\ActivityLogController;

/*
|--------------------------------------------------------------------------
| API Routes (v1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    /*
    |----------------------------------------------------------------------
    | Auth
    |----------------------------------------------------------------------
    */
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1');

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        /*
        |------------------------------------------------------------------
        | Tasks
        |------------------------------------------------------------------
        */
        Route::get('/tasks', [TaskController::class, 'index']);
        Route::put('/tasks/{task}', [TaskController::class, 'update']);
        Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus']);

        Route::middleware('admin')->group(function () {
            Route::post('/tasks', [TaskController::class, 'store']);
            Route::post('/tasks/import', [TaskImportController::class, 'import']);
        });

        /*
        |------------------------------------------------------------------
        | Departments
        |------------------------------------------------------------------
        */
        Route::middleware('admin')->group(function () {
            Route::apiResource('departments', DepartmentController::class)
                ->except(['index', 'show']);
        });

        // index & show → auth kullanıcılar (policy filtreler)
        Route::get('/departments', [DepartmentController::class, 'index']);
        Route::get('/departments/{department}', [DepartmentController::class, 'show']);

        /*
        |------------------------------------------------------------------
        | Department Users
        |------------------------------------------------------------------
        */
        Route::middleware('admin')->group(function () {
            Route::post(
                '/departments/{department}/users/{user}',
                [DepartmentUserController::class, 'store']
            );

            Route::delete(
                '/departments/{department}/users/{user}',
                [DepartmentUserController::class, 'destroy']
            );
        });

        /*
        |------------------------------------------------------------------
        | Activity Logs (Admin)
        |------------------------------------------------------------------
        */
        Route::middleware('admin')->get(
            '/activity-logs',
            [ActivityLogController::class, 'index']
        );
    });
});
