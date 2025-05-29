<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiaChiController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DanhMucSanPhamController;



//Trang chủ
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//

Route::get('/danh-muc/{slug}', [App\Http\Controllers\DanhMucSanPhamController::class, 'showBySlug'])->name('danh-muc.slug');

//

Route::get('/san-pham/{id}', [SanPhamController::class, 'show'])->name('san-pham.show');

// Đăng nhập / Đăng ký / Đăng xuất
Route::get('login', [LoginController::class, 'showLogin'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('register', fn() => view('auth.register'))->name('register.form');
Route::post('register', [LoginController::class, 'register'])->name('register');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

//Middleware Auth
// Admin routes
Route::prefix('admin')->middleware(['auth', 'auth.login'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin');
    // Resource danh mục
    Route::resource('danh-muc', DanhMucSanPhamController::class)
        ->names('danhMuc')
        ->parameters(['danh-muc' => 'danhmuc']);
    // Resource sản phẩm
    Route::resource('san-pham', SanPhamController::class)
        ->names('sanPham')
        ->parameters(['san-pham' => 'sanpham']);
});
// Admin routes (middleware bảo vệ)
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');

    // Hiển thị danh sách người dùng
    Route::get('/list', [UserController::class, 'index'])->name('users.index');

    // Hiển thị chi tiết người dùng
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');

    //  Đặt CREATE lên trên để tránh bị hiểu nhầm là {id}
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');

    // Sửa người dùng
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

    // Cập nhật người dùng
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    // Xóa người dùng
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete');


    Route::get('check/donhang', [DonHangController::class, 'index'])->name('donhang.index');
    Route::get('check/donhang/{id}', [DonHangController::class, 'show'])->name('donhang.show');
    Route::post('check/donhang/{id}/cap-nhat-trang-thai', [DonHangController::class, 'updateStatus'])->name('donhang.updateStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::get('/profile/edit', [UserController::class, 'editUser'])->name('profile.editU');
    Route::put('/profile/update', [UserController::class, 'updateUser'])->name('profile.updateU');

    Route::get('/gio-hang', [GioHangController::class, 'index'])->name('giohang.index');
    Route::post('/gio-hang/them/{sanpham}', [GioHangController::class, 'them'])->name('giohang.them');
    Route::delete('/gio-hang/xoa/{sanpham}', [GioHangController::class, 'remove'])->name('giohang.xoa');


    Route::get('checking/don-hang', [DonHangController::class, 'index'])->name('don-hang.index');
    Route::get('checking/don-hang/{id}', [DonHangController::class, 'show'])->name('user.don-hang.show');
});

//Cart
// Route::get('/gio-hang', [GioHangController::class, 'index'])->name('gioHang.index');
// Route::post('/gio-hang/them/{id}', [GioHangController::class, 'them'])->name('giohang.them');
Route::patch('/gio-hang/cap-nhat/{id}', [GioHangController::class, 'update'])->name('gioHang.update');
// Route::delete('/gio-hang/xoa/{id}', [GioHangController::class, 'remove'])->name('gioHang.remove');

//Địa Chỉ
Route::middleware(['auth'])->group(function () {
    Route::resource('user/dia-chi', DiaChiController::class);
    Route::get('/dia-chi/get-quan-huyen/{thanhPhoId}', [DiaChiController::class, 'getQuanHuyen']);
    Route::get('/dia-chi/get-phuong-xa/{quanHuyenId}', [DiaChiController::class, 'getPhuongXa']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/don-hang', [DonHangController::class, 'store'])->name('don-hang.store');
    Route::get('/don-hang/{id}', [DonHangController::class, 'show'])->name('don-hang.show');
});