@extends('layouts.client')

@section('title', 'Chi tiết đơn hàng - PhoneStore')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Chi tiết đơn hàng #{{ $donHang->id }}</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h5>Thông tin đơn hàng</h5>
                <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($donHang->ngay_dat)->format('d/m/Y H:i:s') }}</p>
                <p><strong>Người nhận:</strong> {{ $donHang->ten_nguoi_nhan }}</p>
                <p><strong>Số điện thoại:</strong> {{ $donHang->so_dien_thoai }}</p>
                <p><strong>Địa chỉ:</strong> {{ $donHang->diaChi->dia_chi_chi_tiet ?? 'N/A' }}, 
                    {{ $donHang->diaChi->phuongXa->ten_phuong_xa ?? 'N/A' }},
                    {{ $donHang->diaChi->quanHuyen->ten_quan_huyen ?? 'N/A' }}, 
                    {{ $donHang->diaChi->thanhPho->ten_thanh_pho ?? 'N/A' }}</p>
                <p><strong>Tổng tiền:</strong> {{ number_format($donHang->tong_tien, 0, ',', '.') }} VNĐ</p>
                <p><strong>Trạng thái:</strong> {{ $donHang->trang_thai }}</p>
                <p><strong>Trạng thái Thanh Toán:</strong> {{ $donHang->trang_thai_thanh_toan }}</p>

                
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5>Sản phẩm trong đơn hàng</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donHang->chiTietDonHangs as $chiTiet)
                            <tr>
                                <td>{{ $chiTiet->sanPham->ten_san_pham ?? 'N/A' }}</td>
                                <td>{{ $chiTiet->so_luong }}</td>
                                <td>{{ number_format($chiTiet->gia, 0, ',', '.') }} VNĐ</td>
                                <td>{{ number_format($chiTiet->gia * $chiTiet->so_luong, 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection