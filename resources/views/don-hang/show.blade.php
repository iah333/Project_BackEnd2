<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Chi Tiết Đơn Hàng</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Chi Tiết Đơn Hàng</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5>Mã Đơn Hàng: {{ $donHang->id }}</h5>
                <p><strong>Người Nhận:</strong> {{ $donHang->ten_nguoi_nhan }}</p>
                <p><strong>Số Điện Thoại:</strong> {{ $donHang->so_dien_thoai }}</p>
                <p><strong>Địa Chỉ Nhận Hàng:</strong> {{ $donHang->diaChi->dia_chi_chi_tiet }},
                    {{ $donHang->diaChi->phuongXa->ten_phuong_xa }},
                    {{ $donHang->diaChi->quanHuyen->ten_quan_huyen }},
                    {{ $donHang->diaChi->thanhPho->ten_thanh_pho }}</p>
                <p><strong>Ngày Đặt:</strong> {{ $donHang->ngay_dat->format('d/m/Y H:i:s') }}</p>
                <p><strong>Trạng Thái:</strong> {{ $donHang->trang_thai }}</p>
                <p><strong>Tổng Tiền:</strong> {{ number_format($donHang->tong_tien, 0, ',', '.') }} VNĐ</p>

                <h5>Chi Tiết Sản Phẩm</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Giá</th>
                            <th>Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donHang->chiTietDonHangs as $chiTiet)
                            <tr>
                                <td>{{ $chiTiet->sanPham->ten_san_pham }}</td>
                                <td>{{ $chiTiet->so_luong }}</td>
                                <td>{{ number_format($chiTiet->gia, 0, ',', '.') }} VNĐ</td>
                                <td>{{ number_format($chiTiet->so_luong * $chiTiet->gia, 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{ route('gio-hang.index') }}" class="btn btn-primary mt-3">Quay Lại Giỏ Hàng</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>