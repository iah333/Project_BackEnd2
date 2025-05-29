<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\GioHang;
use App\Models\DiaChi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonHangController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'dia_chi_id' => 'required|exists:diachi,id',
            'ten_nguoi_nhan' => 'required|string|max:255',
            'so_dien_thoai' => 'required|regex:/^0[0-9]{9}$/',
            'tong_tien' => 'required|numeric|min:0',
        ]);

        $gioHang = GioHang::where('user_id', Auth::id())->firstOrFail();
        $cartItems = $gioHang->sanPhams()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $selectedItems = $request->input('selectedItems', []);
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm để đặt hàng!');
        }

        // Lấy danh sách sản phẩm được chọn
        $selectedCartItems = $cartItems->filter(function ($item) use ($selectedItems) {
            return in_array($item->id, $selectedItems);
        });

        if ($selectedCartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm được chọn!');
        }

        $tongTien = $request->input('tong_tien');

        // Tạo đơn hàng
        $donHang = DonHang::create([
            'user_id' => Auth::id(),
            'dia_chi_id' => $request->dia_chi_id,
            'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
            'so_dien_thoai' => $request->so_dien_thoai,
            'ngay_dat' => now(),
            'tong_tien' => $tongTien,
            'trang_thai' => 'chờ xử lý',
        ]);

        // Lưu chi tiết đơn hàng
        foreach ($selectedCartItems as $item) {
            ChiTietDonHang::create([
                'don_hang_id' => $donHang->id,
                'san_pham_id' => $item->id,
                'so_luong' => $item->pivot->so_luong,
                'gia' => $item->gia,
            ]);
        }

        // Xóa các sản phẩm được chọn khỏi giỏ hàng
        $gioHang->sanPhams()->detach($selectedItems);

        return redirect()->route('don-hang.show', $donHang->id)->with('success', 'Đặt hàng thành công!');
    }


    public function show($id)
    {
        $donHang = DonHang::where('user_id', Auth::id())->with(['diaChi', 'chiTietDonHangs.sanPham'])->findOrFail($id);
        return view('don-hang.show', compact('donHang'));
    }
}