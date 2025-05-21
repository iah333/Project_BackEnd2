<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DanhMucSanPhamController;

//Trang chủ
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Đăng nhập / Đăng ký / Đăng xuất
Route::get('login', [LoginController::class, 'showLogin'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('register', fn() => view('auth.register'))->name('register.form');
Route::post('register', [LoginController::class, 'register'])->name('register');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


// Admin routes (middleware bảo vệ)
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');

    // Hiển thị danh sách người dùng
    Route::get('/list', [UserController::class, 'index'])->name('users.index');

    // Hiển thị chi tiết người dùng
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');

    // Sửa người dùng
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

    // Cập nhật người dùng
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    // Xóa người dùng
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete');

    // Resource danh mục
    Route::resource('danh-muc', DanhMucSanPhamController::class)->names('danhMuc');

    // Resource sản phẩm
    Route::resource('san-pham', SanPhamController::class)->names('sanPham');
});

// Routes cho người dùng thường (không phải admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/users', action: [UserController::class, 'detailsUser'])->name('users.account');
    // Route::get('/tai-khoan/dia-chi', [LoginController::class, 'userAddresses'])->name('user.addresses');
});

Route::get('/danh-muc/{slug}', [App\Http\Controllers\DanhMucSanPhamController::class, 'showBySlug'])->name('danh-muc.slug');

//

Route::get('/san-pham/{ma_san_pham}', [SanPhamController::class, 'show'])->name('san-pham.show');

// // //Detail User
// Route::get('detailsUser', action: [UserController::class,, 'detailsUser'])->name('detailsUser');


// Route::get('listUser', [LoginController::class, 'listUser'])->name('listUser');