<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('administrator')->name('admin.')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/get', [\App\Http\Controllers\Admin\UserController::class, 'getUserList'])->name('list');
            Route::get('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'loadUserData'])->name('setting');
            Route::post('/update-profile/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updateData'])->name('uploadProfile');
        });
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/get', [\App\Http\Controllers\Admin\RoleController::class, 'getAllRoles'])->name('list');
        });
    });
});
