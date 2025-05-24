<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\GioHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DonHangController extends Controller
{
    public function index()
    {
        try {
            $donHangs = DonHang::where('user_id', Auth::id())->with(['diaChi', 'chiTietDonHangs.sanPham'])->get();
            return view('don-hang.index', compact('donHangs'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi tải danh sách đơn hàng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải danh sách đơn hàng.');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Dữ liệu gửi lên:', $request->all());

            $request->validate([
                'dia_chi_id' => 'required|exists:diachi,id',
                'ten_nguoi_nhan' => 'required|string|max:255',
                'so_dien_thoai' => 'required|regex:/^0[0-9]{9}$/',
            ]);

            $gioHang = GioHang::where('user_id', Auth::id())->firstOrFail();
            $cartItems = $gioHang->sanPhams()->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
            }

            $tongTien = $cartItems->sum(function ($item) {
                return $item->gia * $item->pivot->so_luong;
            });

            $donHang = DonHang::create([
                'user_id' => Auth::id(),
                'dia_chi_id' => $request->dia_chi_id,
                'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
                'so_dien_thoai' => $request->so_dien_thoai,
                'ngay_dat' => now(),
                'tong_tien' => $tongTien,
                'trang_thai_thanh_toan' => 'chưa thanh toán',
            ]);

            foreach ($cartItems as $item) {
                ChiTietDonHang::create([
                    'donhang_id' => $donHang->id,
                    'sanpham_id' => $item->id,
                    'so_luong' => $item->pivot->so_luong,
                    'gia' => $item->gia,
                ]);
            }

            $gioHang->sanPhams()->detach();
            return redirect()->route('don-hang.thanh-toan', $donHang->id);
        } catch (\Exception $e) {
            Log::error('Lỗi khi đặt hàng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi đặt hàng.');
        }
    }

    public function thanhToan($id)
    {
        try {
            $donHang = DonHang::where('user_id', Auth::id())->findOrFail($id);
            Log::info('Kiểm tra đơn hàng trước thanh toán:', $donHang->toArray());

            if (!in_array($donHang->trang_thai_thanh_toan, ['chưa thanh toán', 'thất bại'])) {
                return redirect()->route('don-hang.index')->with('error', 'Đơn hàng đã được thanh toán hoặc không hợp lệ!');
            }
            return $this->redirectToVNPay($donHang);
        } catch (\Exception $e) {
            Log::error('Lỗi khi chuyển hướng thanh toán: ' . $e->getMessage());
            return redirect()->route('don-hang.index')->with('error', 'Đã xảy ra lỗi khi chuyển hướng thanh toán.');
        }
    }

    protected function redirectToVNPay($donHang)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/don-hang/callback";
        $vnp_TmnCode = "K6W7KZT9";
        $vnp_HashSecret = "6OUA5L51W4A3AK4MXN27QKPSFHARHT6D";
        
        $vnp_TxnRef = $donHang->id;
        $vnp_OrderInfo = "Thanh toán đơn hàng #" . $donHang->id;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $donHang->tong_tien * 100;
        $vnp_Locale = "vn";
        $vnp_IpAddr = request()->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $vnpSecureHash = hash_hmac('sha512', $query, $vnp_HashSecret);
        $vnp_Url .= '?' . $query . '&vnp_SecureHash=' . $vnpSecureHash;

        return redirect($vnp_Url)->withHeaders(['ngrok-skip-browser-warning' => 'any_value']);
        
        Log::info('Redirect to VNPay with URL:', ['url' => $vnp_Url]);
        return redirect($vnp_Url);
        
    }
    public function callback(Request $request)
    {
        \Log::info('Callback nhận được - Query Params:', $request->all());
        return response()->json(['message' => 'Callback nhận thành công', 'params' => $request->all()]);
    }  
    public function success($id)
    {
        try {
            $donHang = DonHang::where('user_id', Auth::id())->with(['chiTietDonHangs.sanPham'])->findOrFail($id);
            if ($donHang->trang_thai_thanh_toan !== 'thanh toán rồi') {
                return redirect()->route('don-hang.index')->with('error', 'Đơn hàng chưa được thanh toán!');
            }
            return view('don-hang.success', compact('donHang'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi hiển thị trang thanh toán thành công: ' . $e->getMessage());
            return redirect()->route('don-hang.index')->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $donHang = DonHang::where('user_id', Auth::id())->with(['diaChi', 'chiTietDonHangs.sanPham'])->findOrFail($id);
            return view('don-hang.show', compact('donHang'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi hiển thị đơn hàng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải đơn hàng.');
        }
    }
}