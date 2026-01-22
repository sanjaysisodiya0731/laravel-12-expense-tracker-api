<?php

/* use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);

    // Forgot Password
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->group(function () {

    // Expense Tracker API Routes
    Route::get('auth/me',     [AuthController::class, 'me']);
    Route::post('auth/logout',[AuthController::class, 'logout']);
    Route::put('auth/update-profile', [AuthController::class, 'updateProfile']);

    // Expenses CRUD
    Route::get('expenses',        [ExpenseController::class, 'index']);
    Route::post('expenses',       [ExpenseController::class, 'store']);
    Route::put('expenses/{expense}',    [ExpenseController::class, 'update']);
    Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy']);

    // Reports
    Route::get('reports/monthly', [ReportController::class, 'monthly']);

    // Export
    Route::get('export/csv',  [ExportController::class, 'csv']);
    Route::get('export/pdf',  [ExportController::class, 'pdf']);
});

