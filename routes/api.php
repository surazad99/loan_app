<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/loan/apply', [LoanController::class, 'apply']);
    Route::get('/loan/{loan}', [LoanController::class, 'show'])->middleware('can:view,loan');
    Route::patch('/loan/{id}/approve', [LoanController::class, 'approve'])->middleware('can:approve,App\Models\Loan');
    Route::post('/loan/{id}/repay', [LoanController::class, 'repay']);
});

