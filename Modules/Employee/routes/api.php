<?php

use Illuminate\Support\Facades\Route;
use Modules\Employee\Http\Controllers\EmployeeController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('employees', EmployeeController::class)->names('employee');
});

Route::prefix('employees')->group(function () {

    Route::get('/', [EmployeeController::class, 'index']);

    Route::post('/', [EmployeeController::class, 'store']);

    Route::put('/{id}', [EmployeeController::class, 'update']);

    Route::delete('/{id}', [EmployeeController::class, 'destroy']);

    Route::get('/search/{phone}', [EmployeeController::class, 'search']);

});