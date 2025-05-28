@extends('layouts.app')

@section('title', $danhMuc->ten_danh_muc . ' - PhoneStore')

@section('content')
    <!-- Breadcrumb với margin -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb" class="breadcrumb-custom">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $danhMuc->ten_danh_muc }}</li>
            </ol>
        </nav>
    </div>

    <!-- Bao bọc carousel trong khung có bo tròn góc -->
        <div class="container my-3">
            <div class="carousel-wrapper rounded shadow-sm">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('img/banner_AiPsr_PC.png') }}" class="d-block w-100" alt="Sản phẩm 1" style="max-height: 300px; object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/banner_Macbookair_M4-MN_PC.png') }}" class="d-block w-100" alt="Sản phẩm 2" style="max-height: 300px; object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/banner_AiPsr_PC.png') }}" class="d-block w-100" alt="Sản phẩm 3" style="max-height: 300px; object-fit: cover;">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Trước</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Tiếp</span>
                    </button>
                </div>
            </div>
        </div>


    <!-- Hiển thị danh mục và sản phẩm -->
    <div class="main-content">
        <div class="container my-5">
            <h2 class="text-center mb-4">{{ $danhMuc->ten_danh_muc }}</h2>

            @if ($danhMuc->sanPhams->isEmpty())
                <div class="col-12 text-center">
                    <p>Chưa có sản phẩm nào trong danh mục này.</p>
                </div>
            @else
                <div class="row">
                    @foreach ($danhMuc->sanPhams as $sanPham)
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('san-pham.show', $sanPham->id) }}" class="text-decoration-none">
                                <div class="card h-100">
                                    @if ($sanPham->anh)
                                        <img src="{{ asset($sanPham->anh) }}" class="card-img-top" alt="{{ $sanPham->ten_san_pham }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top" alt="No image" style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $sanPham->ten_san_pham }}</h5>
                                        <p class="card-text">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection