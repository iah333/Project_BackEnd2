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
        \Log::info('Sản phẩm tìm thấy', ['sanpham_id' => $sanPham->id]); // Sửa 'ma_san_pham' thành 'id'

        // Lấy hoặc tạo giỏ hàng
        $gioHang = GioHang::firstOrCreate(
            ['user_id' => Auth::id()],
        );
        \Log::info('Giỏ hàng đã tạo hoặc tìm thấy', ['id' => $gioHang->id, 'user_id' => Auth::id()]); // Sửa 'giohang_id' thành 'id'

        // Kiểm tra id
        if (is_null($gioHang->id)) { // Sửa 'giohang_id' thành 'id'
            \Log::error('id là null', ['gio_hang' => $gioHang]);
            throw new \Exception('Không thể lấy id từ giỏ hàng.');
        }

        // Thêm sản phẩm vào bảng giohang_sanpham
        GioHangSanPham::updateOrCreate(
            [
                'giohang_id' => $gioHang->id, // Sửa 'giohang_id' thành 'id' nếu cần
                'sanpham_id' => $sanPham->id, // Sửa 'sanpham_id' thành 'id'
            ],
            ['so_luong' => 1] 
        );

        // Tính tổng số lượng
        $tongSoLuong = GioHangSanPham::where('giohang_id', $gioHang->id)->sum('so_luong'); 

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

public function update(Request $request, $id)
{
    try {
        \Log::info('Bắt đầu cập nhật số lượng', ['sanpham_id' => $id, 'user_id' => Auth::id()]);

        if (!Auth::check()) {
            \Log::error('Người dùng chưa đăng nhập');
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để cập nhật giỏ hàng.');
        }

        $gioHang = GioHang::where('user_id', Auth::id())->firstOrFail();
        \Log::info('Giỏ hàng tìm thấy', ['id' => $gioHang->id]);

        $soLuong = $request->input('so_luong');
        \Log::info('Số lượng nhận được', ['so_luong' => $soLuong]);

        if (!is_numeric($soLuong) || $soLuong < 1) {
            \Log::error('Số lượng không hợp lệ', ['so_luong' => $soLuong]);
            return redirect()->back()->with('error', 'Số lượng không hợp lệ, phải lớn hơn 0.');
        }

        // Lấy thông tin sản phẩm để kiểm tra số lượng tồn
        $sanPham = SanPham::findOrFail($id);
        $soLuongTon = $sanPham->so_luong_ton;
        \Log::info('Số lượng tồn của sản phẩm', ['sanpham_id' => $id, 'so_luong_ton' => $soLuongTon]);

        // Kiểm tra nếu số lượng cập nhật vượt quá số lượng tồn
        $currentQuantity = GioHangSanPham::where('giohang_id', $gioHang->id)
            ->where('sanpham_id', $id)
            ->first();

        if ($currentQuantity) {
            $newTotal = $currentQuantity->so_luong + ($soLuong - $currentQuantity->so_luong);
            if ($newTotal > $soLuongTon) {
                \Log::error('Số lượng vượt quá tồn kho', ['so_luong' => $soLuong, 'so_luong_ton' => $soLuongTon]);
                return redirect()->back()->with('error', 'Số lượng cập nhật vượt quá số lượng tồn (' . $soLuongTon . ').');
            }
        }

        // Cập nhật số lượng
        GioHangSanPham::where('giohang_id', $gioHang->id)
            ->where('sanpham_id', $id)
            ->update(['so_luong' => (int) $soLuong]);

        \Log::info('Cập nhật số lượng thành công', ['so_luong' => $soLuong]);

        // Tính lại tổng số lượng và tổng giá
        $cartItems = $gioHang->sanPhams()->get();
        $tongSoLuong = $cartItems->sum(function ($item) {
            return $item->pivot->so_luong; // Sửa từ so_luong_ton thành so_luong
        });
        $tongGia = $cartItems->sum(function ($item) {
            return $item->gia * $item->pivot->so_luong; // Sửa từ so_luong_ton thành so_luong
        });

        return redirect()->route('gioHang.show')
            ->with('success', 'Cập nhật số lượng thành công!')
            ->with('tongSoLuong', $tongSoLuong)
            ->with('tongGia', $tongGia);
    } catch (\Exception $e) {
        \Log::error('Lỗi khi cập nhật số lượng: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Không thể cập nhật số lượng.');
    }
}

public function remove($id)
{
    try {
        $gioHang = GioHang::where('user_id', Auth::id())->firstOrFail();

        GioHangSanPham::where('giohang_id', $gioHang->id)
            ->where('sanpham_id', $id)
            ->delete();

        $cartItems = $gioHang->sanPhams()->get();
        $tongSoLuong = $cartItems->sum(function ($item) {
            return $item->pivot->so_luong;
        });
        $tongGia = $cartItems->sum(function ($item) {
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
    $gioHang = GioHang::where('user_id', Auth::id())->first();

    if (!$gioHang) {
        return view('gio-hang.index', [
            'cartItems' => collect([]),
            'tongSoLuong' => 0,
            'tongGia' => 0
        ])->with('message', 'Giỏ hàng của bạn hiện tại trống.');
    }

    $cartItems = $gioHang->sanPhams()->get();

    $tongSoLuong = $cartItems->sum(function ($item) {
        return $item->pivot->so_luong;
    });
    $tongGia = $cartItems->sum(function ($item) {
        return $item->gia * $item->pivot->so_luong;
    });

    return view('gio-hang.index', compact('cartItems', 'tongSoLuong', 'tongGia'));
}
}