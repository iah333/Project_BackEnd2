<?php

namespace App\Http\Controllers;

use App\Models\GioHang;
use App\Models\GioHangSanPham;
use App\Models\SanPham;
use App\Models\DiaChi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GioHangController extends Controller
{
    public function them($ma_san_pham)
    {
        try {
            $sanPham = SanPham::findOrFail($ma_san_pham);
            $gioHang = GioHang::firstOrCreate(['user_id' => Auth::id()]);

            if (is_null($gioHang->id)) {
                throw new \Exception('Không thể lấy id từ giỏ hàng.');
            }

            GioHangSanPham::updateOrCreate(
                ['giohang_id' => $gioHang->id, 'sanpham_id' => $sanPham->id],
                ['so_luong' => 1]
            );

            $tongSoLuong = GioHangSanPham::where('giohang_id', $gioHang->id)->sum('so_luong');

            $ma_danh_muc = session('current_category');

            return redirect()->route('sanPham.index', ['ma_danh_muc' => $ma_danh_muc])
                ->with('success', 'Đã thêm sản phẩm vào giỏ hàng!')
                ->with('tongSoLuong', $tongSoLuong);
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm vào giỏ hàng: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Không thể thêm sản phẩm vào giỏ hàng.']);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            if (!Auth::check()) {
                return redirect()->back()->with('error', 'Vui lòng đăng nhập để cập nhật giỏ hàng.');
            }

            $gioHang = GioHang::where('user_id', Auth::id())->firstOrFail();

            $soLuong = $request->input('so_luong');

            if (!is_numeric($soLuong) || $soLuong < 1) {
                return redirect()->back()->with('error', 'Số lượng không hợp lệ, phải lớn hơn 0.');
            }

            $sanPham = SanPham::findOrFail($id);
            $soLuongTon = $sanPham->so_luong_ton;

            $currentQuantity = GioHangSanPham::where('giohang_id', $gioHang->id)->where('sanpham_id', $id)->first();

            if ($currentQuantity) {
                $newTotal = $currentQuantity->so_luong + ($soLuong - $currentQuantity->so_luong);
                if ($newTotal > $soLuongTon) {
                    return redirect()->back()->with('error', 'Số lượng cập nhật vượt quá số lượng tồn (' . $soLuongTon . ').');
                }
            }

            GioHangSanPham::where('giohang_id', $gioHang->id)->where('sanpham_id', $id)->update(['so_luong' => (int) $soLuong]);

            $cartItems = $gioHang->sanPhams()->get();
            $tongSoLuong = $cartItems->sum(function ($item) {
                return $item->pivot->so_luong;
            });
            $tongGia = $cartItems->sum(function ($item) {
                return $item->gia * $item->pivot->so_luong;
            });

            return redirect()->route('gioHang.index') // Sửa từ 'show' thành 'index'
                ->with('success', 'Cập nhật số lượng thành công!')
                ->with('tongSoLuong', $tongSoLuong)
                ->with('tongGia', $tongGia);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật số lượng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể cập nhật số lượng.');
        }
    }

    public function remove($id)
    {
        try {
            $gioHang = GioHang::where('user_id', Auth::id())->firstOrFail();

            GioHangSanPham::where('giohang_id', $gioHang->id)->where('sanpham_id', $id)->delete();

            $cartItems = $gioHang->sanPhams()->get();
            $tongSoLuong = $cartItems->sum(function ($item) {
                return $item->pivot->so_luong;
            });
            $tongGia = $cartItems->sum(function ($item) {
                return $item->gia * $item->pivot->so_luong;
            });

            return redirect()->route('gioHang.index') // Sửa từ 'show' thành 'index'
                ->with('success', 'Xóa sản phẩm khỏi giỏ hàng thành công!')
                ->with('tongSoLuong', $tongSoLuong)
                ->with('tongGia', $tongGia);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa sản phẩm: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể xóa sản phẩm khỏi giỏ hàng.');
        }
    }

    public function index()
    {
        $gioHang = GioHang::where('user_id', Auth::id())->first();

        if (!$gioHang) {
            $cartItems = collect([]);
            $tongSoLuong = 0;
            $tongGia = 0;
            $diaChis = collect([]);
            $message = 'Giỏ hàng của bạn hiện tại trống.';
        } else {
            $cartItems = $gioHang->sanPhams()->get();
            $tongSoLuong = $cartItems->sum(function ($item) {
                return $item->pivot->so_luong;
            });
            $tongGia = $cartItems->sum(function ($item) {
                return $item->gia * $item->pivot->so_luong;
            });
            $diaChis = DiaChi::where('user_id', Auth::id())->get();
            Log::info('DiaChis: ' . $diaChis->count());
        }

        return view('gio-hang.index', compact('gioHang', 'cartItems', 'tongSoLuong', 'tongGia', 'diaChis'))
            ->with('message', $message ?? null);
    }
}
