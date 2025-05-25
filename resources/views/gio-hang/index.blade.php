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
                                <img src="{{ asset($item->anh) }}" alt="{{ $item->ten_san_pham }}"
                                    style="width: 80px; height: auto;">
                            </td>
                            <td>{{ $item->ten_san_pham }}</td>
                            <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <form action="{{ route('gioHang.update', $item->id) }}" method="POST"
                                    class="d-flex align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="so_luong" value="{{ $item->pivot->so_luong }}"
                                        min="1" class="form-control w-25 d-inline" style="max-width: 80px;"
                                        data-gia="{{ $item->gia }}"
                                        onchange="updateTotal(this, {{ $item->id }}, {{ $item->gia }})">
                                    <button type="submit" class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-arrow-repeat"></i> Cập nhật
                                    </button>
                                </form>
                            </td>
                            <td id="total-{{ $item->id }}">
                                {{ number_format($item->gia * $item->pivot->so_luong, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <form action="{{ route('gioHang.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')">
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
                <p><strong>Tổng giá:</strong> <span id="tongGia">{{ number_format($tongGia, 0, ',', '.') }} VNĐ</span>
                </p>
                <a href="{{ route('sanPham.index') }}" class="btn btn-secondary">Tiếp tục mua sắm</a>
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                    data-bs-target="#datHangModal">Đặt Hàng</button>
            </div>
        @endif

        <!-- Modal Đặt Hàng -->
        <div class="modal fade" id="datHangModal" tabindex="-1" aria-labelledby="datHangModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="datHangModalLabel">Xác Nhận Đặt Hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('don-hang.store') }}" method="POST" id="datHangForm">
                            @csrf
                            <!-- Card 1: Thông tin người nhận -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Thông tin người nhận</h5>
                                    <div class="mb-3">
                                        <label for="ten_nguoi_nhan" class="form-label">Tên người nhận</label>
                                        <input type="text" name="ten_nguoi_nhan" id="ten_nguoi_nhan" class="form-control"
                                            value="{{ old('ten_nguoi_nhan', Auth::user()->name) }}" required>
                                        @error('ten_nguoi_nhan')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                        <input type="text" name="so_dien_thoai" id="so_dien_thoai" class="form-control"
                                            value="{{ old('so_dien_thoai') }}" required>
                                        @error('so_dien_thoai')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Địa chỉ nhận hàng -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Địa chỉ nhận hàng</h5>
                                    <div class="mb-3">
                                        <label for="dia_chi_id" class="form-label">Chọn địa chỉ</label>
                                        <select name="dia_chi_id" id="dia_chi_id" class="form-control" required>
                                            <option value="">Chọn địa chỉ</option>
                                            @foreach ($diaChis as $diaChi)
                                                <option value="{{ $diaChi->id }}">
                                                    {{ $diaChi->dia_chi_chi_tiet }},
                                                    {{ $diaChi->phuongXa->ten_phuong_xa ?? 'N/A' }},
                                                    {{ $diaChi->quanHuyen->ten_quan_huyen ?? 'N/A' }},
                                                    {{ $diaChi->thanhPho->ten_thanh_pho ?? 'N/A' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dia_chi_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Tổng thanh toán -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Tổng thanh toán</h5>
                                    <p><strong>Tổng tiền:</strong> <span>{{ number_format($tongGia, 0, ',', '.') }}
                                            VNĐ</span></p>
                                    <button type="submit" class="btn btn-success w-100">Tiến hành đặt hàng</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cập nhật tổng tiền khi thay đổi số lượng
        const prices = {
            @foreach ($cartItems as $item)
                '{{ $item->id }}': {{ $item->gia }},
            @endforeach
        };

        function updateTotal(input, maSanPham, gia) {
            const soLuong = parseInt(input.value) || 0;
            const tong = gia * soLuong;
            document.getElementById('total-' + maSanPham).textContent = new Intl.NumberFormat('vi-VN').format(tong) +
            ' VNĐ';

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

        document.querySelectorAll('input[name="so_luong"]').forEach(input => {
            const maSanPham = input.closest('form').action.split('/').pop();
            const gia = prices[maSanPham] || 0;
            input.setAttribute('data-gia', gia);
        });
    </script>
@endsection
