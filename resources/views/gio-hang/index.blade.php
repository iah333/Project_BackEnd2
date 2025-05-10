@extends('layouts.client')

@section('title', 'Giỏ hàng - PhoneStore')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Giỏ hàng của bạn</h1>

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

        @if ($cartItems->isEmpty())
            <div class="alert alert-info">
                Giỏ hàng của bạn hiện tại trống.
                <a href="{{ route('sanPham.index') }}" class="btn btn-primary mt-2">Tiếp tục mua sắm</a>
            </div>
        @else
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <img src="{{ asset($item->anh) }}" alt="{{ $item->ten_san_pham }}" style="width: 80px; height: auto;">
                            </td>
                            <td>{{ $item->ten_san_pham }}</td>
                            <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <form action="{{ route('gioHang.update', $item->ma_san_pham) }}" method="POST" class="d-flex align-items-center">
                                 @csrf
                                    @method('PATCH')
                                    <input type="number" name="so_luong" value="{{ $item->pivot->so_luong }}" min="1" class="form-control w-25 d-inline" style="max-width: 80px;" data-gia="{{ $item->gia }}" onchange="updateTotal(this, {{ $item->ma_san_pham }}, {{ $item->gia }})">
                                    <button type="submit" class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-arrow-repeat"></i> Cập nhật
                                    </button>
                                </form>
                            </td>
                            <td id="total-{{ $item->ma_san_pham }}">{{ number_format($item->gia * $item->pivot->so_luong, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <form action="{{ route('gioHang.remove', $item->ma_san_pham) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="card p-3 mt-4">
                <h4>Tổng cộng</h4>
                <p><strong>Tổng số lượng:</strong> <span id="tongSoLuong">{{ $tongSoLuong }}</span></p>
                <p><strong>Tổng giá:</strong> <span id="tongGia">{{ number_format($tongGia, 0, ',', '.') }} VNĐ</span></p>
                <a href="{{ route('sanPham.index') }}" class="btn btn-secondary">Tiếp tục mua sắm</a>
                <a href="#" class="btn btn-primary float-end">Đặt Hàng</a>
            </div>
        @endif
    </div>

    <script>
    // Truyền dữ liệu giá của các sản phẩm vào JavaScript
    const prices = {
        @foreach ($cartItems as $item)
            '{{ $item->ma_san_pham }}': {{ $item->gia }},
        @endforeach
    };

    function updateTotal(input, maSanPham, gia) {
        const soLuong = parseInt(input.value) || 0;
        const tong = gia * soLuong;
        document.getElementById('total-' + maSanPham).textContent = new Intl.NumberFormat('vi-VN').format(tong) + ' VNĐ';

        // Tính lại tổng số lượng và tổng giá
        let tongSoLuong = 0;
        let tongGia = 0;
        document.querySelectorAll('input[name="so_luong"]').forEach(input => {
            const soLuongItem = parseInt(input.value) || 0;
            const maSanPhamItem = input.closest('form').action.split('/').pop();
            const giaItem = prices[maSanPhamItem] || 0;
            tongSoLuong += soLuongItem;
            tongGia += giaItem * soLuongItem;
        });

        document.getElementById('tongSoLuong').textContent = tongSoLuong;
        document.getElementById('tongGia').textContent = new Intl.NumberFormat('vi-VN').format(tongGia) + ' VNĐ';
    }

    // Thêm data-gia vào các input dựa trên prices
    document.querySelectorAll('input[name="so_luong"]').forEach(input => {
        const maSanPham = input.closest('form').action.split('/').pop();
        const gia = prices[maSanPham] || 0;
        input.setAttribute('data-gia', gia);
    });
</script>
@endsection