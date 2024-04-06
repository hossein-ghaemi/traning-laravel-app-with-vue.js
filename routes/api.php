<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('administrator')->name('admin')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'getUserList'])->name('userList');
            Route::get('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'loadUserProfile'])->name('userSetting');
            Route::post('/update-profile/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updateProfile'])->name('uploadProfile');
        });
        Route::prefix('roles')->group(function () {
            Route::get('/get', [\App\Http\Controllers\Admin\RoleController::class, 'getAllRoles'])->name('RoleList');
            Route::get('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'loadUserProfile'])->name('userSetting');
        });
    });

});
