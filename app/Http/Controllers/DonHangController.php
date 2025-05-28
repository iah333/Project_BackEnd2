<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\GioHang;
use App\Models\GioHangSanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonHangController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        if (empty($request->selectedItems)) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm để đặt hàng.');
        }

        $validated = $request->validate([
            'ten_nguoi_nhan' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15|regex:/^[0-9]{10,15}$/',
            'dia_chi_id' => 'required|exists:diachi,id,user_id,' . Auth::id(),
            'selectedItems' => 'required|array',
            'selectedItems.*' => 'required|exists:sanpham,id',
        ], [
            'ten_nguoi_nhan.required' => 'Tên người nhận không được để trống.',
            'so_dien_thoai.required' => 'Số điện thoại không được để trống.',
            'so_dien_thoai.regex' => 'Số điện thoại không hợp lệ.',
            'dia_chi_id.required' => 'Vui lòng chọn địa chỉ nhận hàng.',
            'dia_chi_id.exists' => 'Địa chỉ không hợp lệ.',
            'selectedItems.required' => 'Vui lòng chọn sản phẩm.',
            'selectedItems.*.exists' => 'Một số sản phẩm không tồn tại.',
        ]);

        $gioHang = GioHang::where('user_id', Auth::id())->firstOrFail();
        $cartItems = GioHangSanPham::where('giohang_id', $gioHang->id)
            ->whereIn('sanpham_id', $validated['selectedItems'])
            ->with('sanPham')
            ->get();

        $tongGia = $cartItems->sum(function ($item) {
            return $item->sanPham->gia * $item->so_luong;
        });

        if ($tongGia <= 0) {
            return redirect()->route('giohang.index')
                ->with('error', 'Giỏ hàng không có sản phẩm hoặc tổng giá trị bằng 0. Vui lòng thêm sản phẩm.');
        }

        if ($tongGia < 5000) {
            return redirect()->route('giohang.index')
                ->with('error', 'Số tiền giao dịch phải lớn hơn 5,000 VND. Vui lòng thêm sản phẩm khác.');
        }

        try {
            DB::transaction(function () use ($validated, $gioHang, $cartItems, $tongGia) {
                $donHang = DonHang::create([
                    'user_id' => Auth::id(),
                    'dia_chi_id' => $validated['dia_chi_id'],
                    'ten_nguoi_nhan' => $validated['ten_nguoi_nhan'],
                    'so_dien_thoai' => $validated['so_dien_thoai'],
                    'ngay_dat' => now(),
                    'tong_tien' => $tongGia,
                    'trang_thai' => 'chờ thanh toán khi nhận hàng',
                    'phuong_thuc_thanh_toan' => 'cod',
                ]);

                if ($cartItems->isEmpty()) {
                    throw new \Exception('Không có sản phẩm nào được chọn.');
                }

                foreach ($cartItems as $item) {
                    $sanPham = $item->sanPham;
                    if ($item->so_luong > $sanPham->so_luong_ton) {
                        throw new \Exception("Sản phẩm {$sanPham->ten_san_pham} không đủ hàng.");
                    }

                    ChiTietDonHang::create([
                        'donhang_id' => $donHang->id,
                        'sanpham_id' => $sanPham->id,
                        'so_luong' => $item->so_luong,
                        'gia' => $sanPham->gia,
                    ]);

                    $sanPham->decrement('so_luong_ton', $item->so_luong);

                    GioHangSanPham::where([
                        ['giohang_id', $item->giohang_id],
                        ['sanpham_id', $item->sanpham_id],
                    ])->delete();
                }
            });

            $tongSoLuong = $cartItems->sum(fn($item) => $item->so_luong);

            return redirect()->route('giohang.index')
                ->with('success', 'Đặt hàng thành công!')
                ->with('tongSoLuong', $tongSoLuong)
                ->with('tongGia', $tongGia);
        } catch (\Exception $e) {
            Log::error('Lỗi đặt hàng: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage() ?: 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại sau.');
        }
    }
}