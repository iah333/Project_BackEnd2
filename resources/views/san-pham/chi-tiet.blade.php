@extends('layouts.app')

@section('title', $sanPham->ten_san_pham . ' - PhoneStore')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" style="margin-top: -10px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('danh-muc.slug', $sanPham->danhMuc->ten_danh_muc) }}">{{ $sanPham->danhMuc->ten_danh_muc }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $sanPham->ten_san_pham }}</li>
            </ol>
        </nav>
    </div>

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
                <!-- Ảnh chính -->
                <div class="main-image mb-3">
                    <img id="mainImage" src="{{ asset($sanPham->anh) }}" class="img-fluid" alt="{{ $sanPham->ten_san_pham }}" style="max-height: 500px; width: 100%; object-fit: contain;">
                </div>
                <!-- Các ảnh nhỏ -->
                <div class="thumbnail-images d-flex justify-content-between">
                    @for ($i = 1; $i <= 5; $i++)
                        @php
                            // Tạo đường dẫn ảnh nhỏ dựa trên ảnh chính
                            $ext = pathinfo($sanPham->anh, PATHINFO_EXTENSION);
                            $basePath = str_replace('.' . $ext, '', $sanPham->anh);
                            $thumbnailPath = $basePath . "-$i.$ext";
                        @endphp
                        <img src="{{ asset($thumbnailPath) }}" class="thumbnail img-fluid" alt="{{ $sanPham->ten_san_pham }} thumbnail {{ $i }}" style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;" onclick="changeMainImage('{{ asset($thumbnailPath) }}')">
                    @endfor
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h1>{{ $sanPham->ten_san_pham }}</h1>
                <p class="text-muted">Danh mục: {{ $sanPham->danhMuc->ten_danh_muc }}</p>
                <h3 class="text-danger">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</h3>
                <p><strong>Số lượng tồn kho:</strong> {{ $sanPham->so_luong_ton }} sản phẩm</p>
                @if ($sanPham->mo_ta)
                    <p><strong>Mô tả:</strong> {{ $sanPham->mo_ta }}</p>
                @endif

                <!-- Nút hành động -->
                <div class="mt-4">
                    @if ($sanPham->so_luong_ton > 0)
                        <form action="{{ route('giohang.them', $sanPham->id) }}" method="POST" class="d-inline">
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

    <!-- JavaScript để thay đổi ảnh chính khi nhấp vào ảnh nhỏ -->
    <script>
        function changeMainImage(newSrc) {
            document.getElementById('mainImage').src = newSrc;
        }
    </script>

    <!-- CSS để tùy chỉnh giao diện -->
    <style>
        .main-image {
            background-color: #fff; /* Màu trắng */
            border: 1px solid #ccc; /* Viền xám nhạt */
            padding: 10px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2), -5px -5px 15px rgba(255, 255, 255, 0.8); /* Hiệu ứng 3D */
        }

        .thumbnail {
            border: 1px solid #ddd;
            padding: 5px;
            transition: border-color 0.3s ease;
        }

        .thumbnail:hover {
            border-color: #007bff;
        }

        .thumbnail-images {
            width: 100%; /* Đảm bảo các ảnh nhỏ chiếm toàn chiều ngang */
        }
    </style>
@endsection