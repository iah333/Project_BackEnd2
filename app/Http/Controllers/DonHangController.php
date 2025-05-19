<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\GioHang;
use App\Models\DiaChi;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DonHangController extends Controller
{
    public function create()
    {
        $gioHangs = GioHang::where('user_id', Auth::id())->with('sanPham')->get();
        $diaChis = DiaChi::where('user_id', Auth::id())->get();
        $tongTien = $gioHangs->sum(function ($gioHang) {
            return $gioHang->so_luong * $gioHang->sanPham->gia;
        });

        return view('don-hang.create', compact('gioHangs', 'diaChis', 'tongTien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dia_chi_id' => 'required|exists:diachi,id',
        ]);

        $gioHangs = GioHang::where('user_id', Auth::id())->with('sanPham')->get();
        if ($gioHangs->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $tongTien = $gioHangs->sum(function ($gioHang) {
            return $gioHang->so_luong * $gioHang->sanPham->gia;
        });

        // Tạo đơn hàng
        $donHang = DonHang::create([
            'user_id' => Auth::id(),
            'dia_chi_id' => $request->dia_chi_id,
            'ngay_dat' => now(),
            'tong_tien' => $tongTien,
            'trang_thai' => 'chờ xử lý',
        ]);

        // Lưu chi tiết đơn hàng
        foreach ($gioHangs as $gioHang) {
            ChiTietDonHang::create([
                'don_hang_id' => $donHang->id,
                'san_pham_id' => $gioHang->san_pham_id,
                'so_luong' => $gioHang->so_luong,
                'gia' => $gioHang->sanPham->gia,
            ]);

            // Cập nhật số lượng tồn kho
            $sanPham = $gioHang->sanPham;
            $sanPham->so_luong_ton -= $gioHang->so_luong;
            $sanPham->save();
        }

        // Xóa giỏ hàng sau khi đặt hàng
        GioHang::where('user_id', Auth::id())->delete();

        return redirect()->route('don-hang.show', $donHang->id)->with('success', 'Đặt hàng thành công!');
    }

    public function show($id)
    {
        $donHang = DonHang::where('user_id', Auth::id())->with(['diaChi', 'chiTietDonHangs.sanPham'])->findOrFail($id);
        return view('don-hang.show', compact('donHang'));
    }
}