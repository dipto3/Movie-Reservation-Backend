<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Authorization\RoleManageController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\CheckToken;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:admin-api', 'admin', CheckToken::using('admin')])->group(function () {
    Route::get('check', [AuthController::class, 'check']);
    Route::get('permissions', [AuthController::class, 'permissions']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('/role', RoleManageController::class)->middleware('permission:role');
    Route::get('roles/active', [RoleManageController::class, 'activeRoles']);
    Route::get('/all-permissions', [RoleManageController::class, 'groupWisePermissions']);
});