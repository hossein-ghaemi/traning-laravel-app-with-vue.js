<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('administrator')->name('admin')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'getUserList'])->name('userList');
        });
    });
});
