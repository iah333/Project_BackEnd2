<?php

namespace App\Http\Controllers;

use App\Models\GioHang;
use App\Models\GioHangSanPham;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GioHangController extends Controller
{
    public function them($ma_san_pham)
{
    try {
        $sanPham = SanPham::findOrFail($ma_san_pham);
        \Log::info('Sản phẩm tìm thấy', ['ma_san_pham' => $sanPham->ma_san_pham]);

        // Lấy hoặc tạo giỏ hàng
        $gioHang = GioHang::firstOrCreate(
            ['user_id' => Auth::id()],
            ['ngay_tao' => now()]
        );
        \Log::info('Giỏ hàng đã tạo hoặc tìm thấy', ['giohang_id' => $gioHang->giohang_id, 'user_id' => Auth::id()]);

        // Kiểm tra ma_gio_hang
        if (is_null($gioHang->ma_gio_hang)) {
            \Log::error('giohang_id là null', ['gio_hang' => $gioHang]);
            throw new \Exception('Không thể lấy giohang_id từ giỏ hàng.');
        }

        // Thêm sản phẩm vào bảng giohang_sanpham
        GioHangSanPham::updateOrCreate(
            [
                'giohang_id' => $gioHang->giohang_id, // Sửa thành 'gio_hang_id' nếu cần
                'sanpham_id' => $sanPham->sanpham_id,
            ],
            ['so_luong' => 1]
        );

        // Tính tổng số lượng
        $tongSoLuong = GioHangSanPham::where('giohang_id', $gioHang->giohang_id)->sum('so_luong');

        // Lấy danh mục hiện tại từ session
        $ma_danh_muc = session('current_category');

        return redirect()->route('sanPham.index', ['ma_danh_muc' => $ma_danh_muc])
            ->with('success', 'Đã thêm sản phẩm vào giỏ hàng!')
            ->with('tongSoLuong', $tongSoLuong);
    } catch (\Exception $e) {
        \Log::error('Lỗi khi thêm vào giỏ hàng: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Không thể thêm sản phẩm vào giỏ hàng.']);
    }
}

    public function update(Request $request, $ma_san_pham)
{
    try {
        \Log::info('Bắt đầu cập nhật số lượng', ['ma_san_pham' => $ma_san_pham, 'user_id' => Auth::id()]);

        if (!Auth::check()) {
            \Log::error('Người dùng chưa đăng nhập');
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để cập nhật giỏ hàng.');
        }

        $gioHang = GioHang::where('id', Auth::id())->firstOrFail(); // Thay 'id' bằng tên cột thực tế (ví dụ 'user_id')
        \Log::info('Giỏ hàng tìm thấy', ['ma_gio_hang' => $gioHang->ma_gio_hang]);

        $soLuong = $request->input('so_luong');
        \Log::info('Số lượng nhận được', ['so_luong' => $soLuong]);

        if (!is_numeric($soLuong) || $soLuong < 1) {
            \Log::error('Số lượng không hợp lệ', ['so_luong' => $soLuong]);
            return redirect()->back()->with('error', 'Số lượng không hợp lệ, phải lớn hơn 0.');
        }

        // Cập nhật số lượng trong bảng giohang_sanpham
        GioHangSanPham::where('ma_gio_hang', $gioHang->ma_gio_hang)
            ->where('ma_san_pham', $ma_san_pham)
            ->update(['so_luong' => (int) $soLuong]);
        \Log::info('Cập nhật số lượng thành công', ['so_luong' => $soLuong]);

        // Tính lại tổng số lượng và tổng giá
        $tongSoLuong = GioHangSanPham::where('ma_gio_hang', $gioHang->ma_gio_hang)->sum('so_luong');
        $tongGia = SanPham::join('giohang_sanpham', 'san_pham.ma_san_pham', '=', 'giohang_sanpham.ma_san_pham')
            ->where('giohang_sanpham.ma_gio_hang', $gioHang->ma_gio_hang)
            ->sum('san_pham.gia * giohang_sanpham.so_luong');

        return redirect()->route('gioHang.show')
            ->with('success', 'Cập nhật số lượng thành công!')
            ->with('tongSoLuong', $tongSoLuong)
            ->with('tongGia', $tongGia);
    } catch (\Exception $e) {
        \Log::error('Lỗi khi cập nhật số lượng: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Không thể cập nhật số lượng.');
    }
}

    public function remove($ma_san_pham)
    {
        try {
            $gioHang = GioHang::where('user_id', Auth::id())->firstOrFail(); // Thay 'id' bằng tên cột thực tế

            // Xóa sản phẩm khỏi giỏ hàng
            GioHangSanPham::where('ma_gio_hang', $gioHang->ma_gio_hang)
                ->where('ma_san_pham', $ma_san_pham)
                ->delete();

            // Cập nhật lại tổng số lượng và tổng giá
            $tongSoLuong = $gioHang->sanPhams()->sum('pivot.so_luong');
            $tongGia = $gioHang->sanPhams()->sum(function ($item) {
                return $item->gia * $item->pivot->so_luong;
            });

            return redirect()->route('gioHang.show')
                ->with('success', 'Xóa sản phẩm khỏi giỏ hàng thành công!')
                ->with('tongSoLuong', $tongSoLuong)
                ->with('tongGia', $tongGia);
        } catch (\Exception $e) {
            \Log::error('Lỗi khi xóa sản phẩm: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể xóa sản phẩm khỏi giỏ hàng.');
        }
    }

    public function showCart()
    {
        $gioHang = GioHang::where('user_id', Auth::id())->first(); // Thay 'id' bằng tên cột thực tế

        if (!$gioHang) {
            return view('gio-hang.index', [
                'cartItems' => collect([]),
                'tongSoLuong' => 0,
                'tongGia' => 0
            ])->with('message', 'Giỏ hàng của bạn hiện tại trống.');
        }

        $cartItems = $gioHang->sanPhams()->withPivot('so_luong')->get();

        $tongSoLuong = $cartItems->sum('pivot.so_luong');
        $tongGia = $cartItems->sum(function ($item) {
            return $item->gia * $item->pivot->so_luong;
        });

        return view('gio-hang.index', compact('cartItems', 'tongSoLuong', 'tongGia'));
    }
}