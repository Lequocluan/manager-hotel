<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookedRoomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuestsController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\NewsController as UserNewsController;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

Route::middleware(['auth:admin', 'role:admin|superadmin'])->prefix('admin')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password.form');
    Route::post('forgot-password', [AuthController::class, 'handleForgotPassword'])->name('forgot-password.send');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset-password.form');
    Route::post('reset-password', [AuthController::class, 'handleResetPassword'])->name('reset-password');
});

Route::get('admin/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');


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
    Route::post('/room-types/upload-temp', [RoomTypeController::class, 'uploadTemp']);
    Route::post('/room-types/revert-temp', [RoomTypeController::class, 'revertTemp']);
    Route::post('/room-types/remove-existing-image', [RoomTypeController::class, 'removeExistingImage']);
    Route::put('/room-types/{id}', [RoomTypeController::class, 'update']);

    Route::resource('/services', ServiceController::class);
    Route::resource('/news-category', NewsCategoryController::class);
    Route::resource('/news', NewsController::class);
    Route::resource('/guests', GuestsController::class);

    Route::resource('booked-rooms', BookedRoomController::class);
    Route::get('booked-rooms/{id}/print', [BookedRoomController::class, 'print'])->name('booked-rooms.print');
    Route::get('booked-rooms/{id}/export-pdf', [BookedRoomController::class, 'exportPdf'])->name('booked-rooms.exportPdf');

    
    Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('admin.contacts.show');
    Route::post('/contacts/{id}/reply', [ContactController::class, 'reply'])->name('admin.contacts.reply');
    Route::delete('/contact/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
});

Route::get('/', [HomeController::class, 'index']) -> name('home');

Route::get('/about-us', [HomeController::class, 'aboutUs']) -> name('about-us');
Route::get('/contact', [HomeController::class, 'contact']) -> name('contact');
Route::post('/contact/send', [HomeController::class, 'store'])->name('contact.send');

Route::get('/room-types', [HomeController::class, 'listRoomTypes']) -> name('roomtypes.list');
Route::get('/room-types/{slug}', [HomeController::class, 'roomtypeDetail']) -> name('roomtype.detail');


Route::get('/booking/start', [BookingController::class, 'start'])->name('booking.start');
Route::post('/booking/step1', [BookingController::class, 'step1'])->name('booking.step1');

Route::get('/booking/select-room', [BookingController::class, 'selectRoom'])->name('booking.selectRoom');
Route::post('/booking/step2', [BookingController::class, 'step2'])->name('booking.step2');

Route::get('/booking/select-services', [BookingController::class, 'selectServices'])->name('booking.selectServices');
Route::post('/booking/step3', [BookingController::class, 'step3'])->name('booking.step3');

Route::get('/booking/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
Route::post('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
Route::get('/booking/success', function () {
    $bookingId = session('booking_id');
    if (!$bookingId) return redirect()->route('booking.start')->with('error', 'Không tìm thấy thông tin đặt phòng.');

    $booking = Booking::with(['rooms', 'services'])->findOrFail($bookingId);

    return view('user.booking.success', compact('booking'));
})->name('booking.success');



Route::get('/{slugCategory}/{slugBlog}', [UserNewsController::class, 'blog_detail']) -> name('news.blog-detail');
Route::get('/{slug}', [UserNewsController::class, 'category']) -> name('news.category');