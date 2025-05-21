<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Đặt Hàng</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Đặt Hàng</h2>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($gioHangs->isEmpty())
            <p>Giỏ hàng của bạn đang trống!</p>
            <a href="{{ route('gio-hang.index') }}" class="btn btn-primary">Quay lại giỏ hàng</a>
        @else
            <h4>Sản phẩm trong giỏ hàng</h4>
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
                    @foreach ($gioHangs as $gioHang)
                        <tr>
                            <td>{{ $gioHang->sanPham->ten_san_pham }}</td>
                            <td>{{ $gioHang->so_luong }}</td>
                            <td>{{ number_format($gioHang->sanPham->gia, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($gioHang->so_luong * $gioHang->sanPham->gia, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Tổng Tiền</th>
                        <th>{{ number_format($tongTien, 0, ',', '.') }} VNĐ</th>
                    </tr>
                </tfoot>
            </table>

            <form action="{{ route('don-hang.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="dia_chi_id" class="form-label">Chọn Địa Chỉ Nhận Hàng</label>
                    <select name="dia_chi_id" id="dia_chi_id" class="form-control" required>
                        <option value="">Chọn địa chỉ</option>
                        @foreach ($diaChis as $diaChi)
                            <option value="{{ $diaChi->id }}">
                                {{ $diaChi->dia_chi_chi_tiet }}, {{ $diaChi->phuongXa->ten_phuong_xa }},
                                {{ $diaChi->quanHuyen->ten_quan_huyen }}, {{ $diaChi->thanhPho->ten_thanh_pho }}
                            </option>
                        @endforeach
                    </select>
                    @error('dia_chi_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Xác Nhận Đặt Hàng</button>
                <a href="{{ route('gio-hang.index') }}" class="btn btn-secondary">Quay Lại</a>
            </form>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>