<?php

use App\Http\Controllers\Authorization\RoleManageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\CheckToken;

Route::middleware(['auth:admin-api', 'admin', CheckToken::using('admin')])->group(function () {
  

    Route::apiResource('/role', RoleManageController::class)->middleware('permission:role');
    Route::get('roles/active', [RoleManageController::class, 'activeRoles']);
    Route::get('/all-permissions', [RoleManageController::class, 'groupWisePermissions']);
});

