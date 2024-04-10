<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Helpers\RouteHelper;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('administrator')->name('admin')->group(function () {
        Route::prefix('users')->name('users')->group(function () {

            (new RouteHelper(Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'getUserList'])->name('userList')))
                ->addTitle('List of users')
                ->addAccessRole('admin');

            (new RouteHelper(Route::get('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'loadUserProfile'])->name('userSetting')))
                ->addTitle('Get data one user')
                ->addAccessRole('admin');

            (new RouteHelper(Route::post('/update-profile/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updateProfile'])->name('uploadProfile')))
                ->addTitle('Update data one user')
                ->addAccessRole('admin');

        });
        Route::prefix('roles')->name('roles')->group(function () {
            Route::get('/get', [\App\Http\Controllers\Admin\RoleController::class, 'getAllRoles'])->name('RoleList');

        });
    });

});
