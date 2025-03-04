<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
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


Route::get('/admin/login', [AuthController::class, 'form_login']) ->name('login');
Route::post('/admin/login', [AuthController::class, 'login']) ->name('handleLogin');
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/', [DashboardController::class,'dashboard'] ) -> name('admin.dashboard');
    Route::resource('/manager', AdminController::class);
});
