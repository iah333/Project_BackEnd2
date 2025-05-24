@extends('layouts.client')

@section('title', 'Thanh toán thành công - PhoneStore')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4 text-success">Thanh toán thành công!</h1>

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

        <h3>Thông tin đơn hàng #{{ $donHang->id }}</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ảnh sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donHang->chiTietDonHangs as $chiTiet)
                    <tr>
                        <td>
                            @if ($chiTiet->sanPham->anh_san_pham)
                                <img src="{{ asset('storage/' . $chiTiet->sanPham->anh_san_pham) }}" alt="{{ $chiTiet->sanPham->ten_san_pham }}" style="width: 100px; height: auto;">
                            @else
                                <span>Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ $chiTiet->sanPham->ten_san_pham }}</td>
                        <td>{{ $chiTiet->so_luong }}</td>
                        <td>{{ number_format($chiTiet->gia, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('don-hang.index') }}" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
    </div>
@endsection