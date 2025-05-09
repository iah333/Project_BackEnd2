@extends('layouts.app')

@section('title', 'Trang Chủ - PhoneStore')

@section('content')
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/banner_AiPsr_PC.png') }}" class="d-block w-100" alt="Sản phẩm 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/banner_Macbookair_M4-MN_PC.png') }}" class="d-block w-100" alt="Sản phẩm 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/banner_AiPsr_PC.png') }}" class="d-block w-100" alt="Sản phẩm 3">
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

    <!-- Hiển thị danh mục và sản phẩm ngẫu nhiên -->
    @foreach ($danhMucSanPham as $danhMuc)
        <div class="container my-5">
            <h2 class="text-center mb-4">{{ $danhMuc->ten_danh_muc }}</h2>
            <div class="row">
                @if ($danhMuc->sanPhams->isNotEmpty())
                    @foreach ($danhMuc->sanPhams->random(min(4, $danhMuc->sanPhams->count())) as $sanPham)
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('san-pham.show', $sanPham->ma_san_pham) }}" class="text-decoration-none">
                                <div class="card h-100">
                                    <img src="{{ asset($sanPham->anh) }}" class="card-img-top" alt="{{ $sanPham->ten_san_pham }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $sanPham->ten_san_pham }}</h5>
                                        <p class="card-text">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p>Không có sản phẩm trong danh mục này.</p>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
@endsection