<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::prefix('api')
    ->middleware( [
        \App\Http\Middleware\CheckAccess::class,
    ])
    ->namespace('api')
    ->group(base_path('routes/api.php'));


Route::get('{any?}', function() {
    return view('application');
})->where('any', '.*');
