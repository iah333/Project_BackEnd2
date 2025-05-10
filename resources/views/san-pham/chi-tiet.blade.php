@extends('layouts.client')

@section('title', $sanPham->ten_san_pham . ' - PhoneStore')

@section('content')
    <div class="container my-5">
        <!-- Hiển thị thông báo thành công và tổng số lượng -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                @if (session('tongSoLuong'))
                    - Tổng số lượng trong giỏ hàng: {{ session('tongSoLuong') }}
                @endif
                <a href="{{ route('gioHang.show') }}" class="btn btn-link">Xem giỏ hàng</a>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <div class="row">
            <!-- Ảnh sản phẩm -->
            <div class="col-md-6">
                <img src="{{ asset($sanPham->anh) }}" class="img-fluid" alt="{{ $sanPham->ten_san_pham }}">
            </div>
            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h1>{{ $sanPham->ten_san_pham }}</h1>
                <p class="text-muted">Danh mục: {{ $sanPham->danhMuc->ten_danh_muc }}</p>
                <h3 class="text-danger">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</h3>
                <p><strong>Số lượng tồn kho:</strong> {{ $sanPham->so_luong_ton }} sản phẩm</p>
                @if($sanPham->mo_ta)
                    <p><strong>Mô tả:</strong> {{ $sanPham->mo_ta }}</p>
                @endif
                <p><strong>Ngày thêm:</strong> {{ $sanPham->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Cập nhật lần cuối:</strong> {{ $sanPham->updated_at->format('d/m/Y H:i') }}</p>

                <!-- Nút hành động -->
                <div class="mt-4">
                    @if($sanPham->so_luong_ton > 0)
                        <form action="{{ route('gioHang.them', $sanPham->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ hàng
                            </button>
                        </form>
                    @else
                        <p class="text-danger">Hết hàng</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection