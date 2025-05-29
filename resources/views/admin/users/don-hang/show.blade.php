@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chi tiết đơn hàng #{{ $donHang->id }}</h1>

        <!-- Thông tin đơn hàng -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>Thông tin đơn hàng</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID Đơn hàng</th>
                        <td>{{ $donHang->id }}</td>
                    </tr>
                    <tr>
                        <th>Người đặt</th>
                        <td>{{ $donHang->user ? $donHang->user->name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tên người nhận</th>
                        <td>{{ $donHang->ten_nguoi_nhan }}</td>
                    </tr>
                    <tr>
                        <th>Số điện thoại</th>
                        <td>{{ $donHang->so_dien_thoai }}</td>
                    </tr>
                    <tr>
                        <th>Ngày đặt</th>
                        <td>{{ $donHang->ngay_dat->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Tổng tiền</th>
                        <td>{{ number_format($donHang->tong_tien, 0, ',', '.') }} VND</td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>{{ $donHang->trang_thai }}</td>
                    </tr>
                    <tr>
                        <th>Phương thức thanh toán</th>
                        <td>{{ $donHang->phuong_thuc_thanh_toan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Thông tin địa chỉ -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>Địa chỉ giao hàng</h3>
            </div>
            <div class="card-body">
                @if ($donHang->diaChi)
                    <p><strong>Địa chỉ:</strong> {{ $donHang->diaChi->dia_chi_chi_tiet }}</p>
                    <p><strong>Phường/Xã:</strong>
                        {{ $donHang->diaChi->phuongXa ? $donHang->diaChi->phuongXa->ten_phuong_xa : 'N/A' }}</p>
                    <p><strong>Quận/Huyện:</strong>
                        {{ $donHang->diaChi->quanHuyen ? $donHang->diaChi->quanHuyen->ten_quan_huyen : 'N/A' }}</p>
                    <p><strong>Tỉnh/Thành phố:</strong>
                        {{ $donHang->diaChi->thanhPho ? $donHang->diaChi->thanhPho->ten_thanh_pho : 'N/A' }}</p>
                @else
                    <p>Không có thông tin địa chỉ.</p>
                @endif
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>Sản phẩm trong đơn hàng</h3>
            </div>
            <div class="card-body">
                @if ($donHang->chiTietDonHangs->isEmpty())
                    <p>Không có sản phẩm nào trong đơn hàng.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donHang->chiTietDonHangs as $chiTiet)
                                <tr>
                                    <td>{{ $chiTiet->sanPham ? $chiTiet->sanPham->ten_san_pham : 'N/A' }}</td>
                                    <td>{{ $chiTiet->so_luong }}</td>
                                    <td>{{ number_format($chiTiet->gia, 0, ',', '.') }} VND</td>
                                    <td>{{ number_format($chiTiet->gia * $chiTiet->so_luong, 0, ',', '.') }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Nút quay lại -->
        <a href="{{ route(auth()->user()->is_admin ? 'donhang.index' : 'don-hang.index') }}" class="btn btn-secondary">Quay
            lại</a>
    </div>
@endsection
