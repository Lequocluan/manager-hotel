<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\RoomController;
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
    Route::get('/logout', [AuthController::class, 'logout']) -> name('admin.logout');
    Route::prefix('/profile')->group(function(){
        Route::get('/', [AuthController::class, 'profile']) -> name('admin.profile');
        Route::post('/update-avatar', [AuthController::class, 'update_avatar'])->name('admin.update-avatar');
        Route::get('/update-password', [AuthController::class, 'update_password'])->name('admin.update-password');
        Route::post('/update-password', [AuthController::class, 'handle_update_password'])->name('admin.handle_update_password');
        Route::get('/edit-account', [AuthController::class, 'edit_account'])->name('admin.edit-account');
        Route::post('/edit-account', [AuthController::class, 'handle_edit_account'])->name('admin.handle_edit_account');
    });
    Route::resource('/room-types', RoomTypeController::class);
    Route::resource('/rooms', RoomController::class);
    Route::resource('/manager', AdminController::class);
});
