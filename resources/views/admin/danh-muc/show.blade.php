@extends('layouts.app')

@section('title', $danhMuc->ten_danh_muc . ' - PhoneStore')

@section('content')
    <!-- Breadcrumb với margin -->
    <div class="container mt-4">
        <nav aria-label="breadcrumb" class="breadcrumb-custom">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $danhMuc->ten_danh_muc }}</li>
            </ol>
        </nav>
    </div>

    <!-- Carousel -->
<div class="container my-4">
    <div class="carousel-wrapper rounded shadow-sm">
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @if ($danhMuc->carouselImages->isNotEmpty())
                    @foreach ($danhMuc->carouselImages as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('img/' . $image->image_path) }}" class="d-block w-100 carousel-image" alt="Ảnh carousel {{ $index + 1 }}">
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item active">
                        <img src="{{ asset('img/banner_iP16sr_PC.png') }}" class="d-block w-100 carousel-image" alt="Sản phẩm 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/banner_iPhone16pro_max.png') }}" class="d-block w-100 carousel-image" alt="Sản phẩm 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/banner_iphone15.png') }}" class="d-block w-100 carousel-image" alt="Sản phẩm 3">
                    </div>
                @endif
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
            <h2 class="text-center mb-5 category-title">{{ $danhMuc->ten_danh_muc }}</h2>

            @if ($danhMuc->sanPhams->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted fs-5">Chưa có sản phẩm nào trong danh mục này.</p>
                </div>
            @else
                <div class="row">
                    @foreach ($danhMuc->sanPhams as $sanPham)
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('san-pham.show', $sanPham->id) }}" class="text-decoration-none">
                                <div class="card h-100 product-card shadow-sm">
                                    @if ($sanPham->anh)
                                        <img src="{{ asset($sanPham->anh) }}" class="card-img-top product-image" alt="{{ $sanPham->ten_san_pham }}">
                                    @else
                                        <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top product-image" alt="No image">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title product-title">{{ $sanPham->ten_san_pham }}</h5>
                                        <p class="card-text price-text">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/danh-muc.css') }}">
@endpush