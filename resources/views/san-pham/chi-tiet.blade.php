@extends('layouts.app')

@section('title', $sanPham->ten_san_pham . ' - PhoneStore')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" style="margin-top: -10px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('danh-muc.slug', $sanPham->danhMuc ? $sanPham->danhMuc->ten_danh_muc : '') }}">{{ $sanPham->danhMuc ? $sanPham->danhMuc->ten_danh_muc : 'Không có danh mục' }}</a></li>
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
                <a href="{{ route('giohang.index') }}" class="btn btn-link">Xem giỏ hàng</a>
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
                <p class="text-muted">Danh mục: {{ $sanPham->danhMuc ? $sanPham->danhMuc->ten_danh_muc : 'Không có danh mục' }}</p>
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

        <!-- Sản phẩm tương tự -->
        <div class="row mt-5">
            <h4>Sản phẩm tương tự</h4>
            <div class="row">
                @php
                    // Trích xuất dòng sản phẩm và số/kích thước/chip
                    $baseName = preg_replace('/\d+|-inch|M\d|Max|Ultra/', '', $sanPham->ten_san_pham);
                    preg_match('/\d+|-inch|M\d|Max|Ultra/', $sanPham->ten_san_pham, $matches);
                    $versionPart = $matches[0] ?? '';

                    // Tìm các sản phẩm cùng danh mục có cùng dòng và phần số/kích thước/chip
                    $similarProducts = \App\Models\SanPham::where('danhmuc_id', $sanPham->danhmuc_id)
                        ->where('id', '!=', $sanPham->id)
                        ->where(function ($query) use ($baseName, $versionPart, $sanPham) {
                            $query->where('ten_san_pham', 'like', $baseName . '%')
                                  ->where('ten_san_pham', 'not like', '%' . $sanPham->ten_san_pham . '%')
                                  ->orWhere(function ($q) use ($versionPart, $sanPham) {
                                      $q->where('ten_san_pham', 'like', '%' . $versionPart . '%')
                                        ->where('ten_san_pham', 'not like', '%' . $sanPham->ten_san_pham . '%');
                                  });
                        })
                        ->take(4)
                        ->get();
                @endphp
                @forelse ($similarProducts as $similar)
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <img src="{{ asset($similar->anh) }}" class="card-img-top" alt="{{ $similar->ten_san_pham }}" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $similar->ten_san_pham }}</h5>
                                <p class="card-text text-danger">{{ number_format($similar->gia, 0, ',', '.') }} VNĐ</p>
                                <a href="{{ route('san-pham.show', $similar->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Không có sản phẩm tương tự.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- JavaScript để thay đổi ảnh chính khi nhấp vào ảnh nhỏ -->
    <script>
        function changeMainImage(newSrc) {
            document.getElementById('mainImage').src = newSrc;
        }
    </script>


@endsection