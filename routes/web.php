<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\DanhMucSanPhamController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\DiaChiController;
use App\Http\Controllers\DonHangController;



//Trang chủ
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//

Route::get('/danh-muc/{slug}', [App\Http\Controllers\DanhMucSanPhamController::class, 'showBySlug'])->name('danh-muc.slug');

//

Route::get('/san-pham/{id}', [SanPhamController::class, 'show'])->name('san-pham.show');


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
Route::get('login', [LoginController::class, 'Showlogin'])->name('showlogin');
Route::post('login', [LoginController::class, 'Login'])->name('login');

//Đăng kí
Route::get('register', function () {
    return view('auth.register');
});
Route::post('register', [LoginController::class, 'register'])->name('register');


//Logout
Route::get('signout', [LoginController::class, 'signOut'])->name('signout');
Route::post('logout', [LoginController::class, 'signOut'])->name('logout'); // Thêm route POST mới

//Detail User
Route::get('detailsUser', [LoginController::class, 'detailsUser'])->name('detailsUser');


Route::get('listUser', [LoginController::class, 'listUser'])->name('listUser');

Route::get('admin/update', [LoginController::class, 'showupdatea'])->name('showupdatea');
Route::post('admin/update', [LoginController::class, 'updateAdmin'])->name('updateAdmin');




//Cart
Route::get('/gio-hang', [GioHangController::class, 'index'])->name('gioHang.index');
Route::post('/gio-hang/them/{id}', [GioHangController::class, 'them'])->name('gioHang.them');
Route::patch('/gio-hang/cap-nhat/{id}', [GioHangController::class, 'update'])->name('gioHang.update');
Route::delete('/gio-hang/xoa/{id}', [GioHangController::class, 'remove'])->name('gioHang.remove');

//Địa Chỉ 
Route::middleware(['auth'])->group(function () {
    Route::resource('dia-chi', DiaChiController::class);
    Route::get('/dia-chi/get-quan-huyen/{thanhPhoId}', [DiaChiController::class, 'getQuanHuyen']);
    Route::get('/dia-chi/get-phuong-xa/{quanHuyenId}', [DiaChiController::class, 'getPhuongXa']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/don-hang', [DonHangController::class, 'store'])->name('don-hang.store');
    Route::get('/don-hang/{id}', [DonHangController::class, 'show'])->name('don-hang.show');
});
