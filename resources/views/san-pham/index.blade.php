@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm - PhoneStore')

@section('content')
<div class="container mx-auto my-6 px-4">
    <!-- Tiêu đề và thanh tìm kiếm -->
    <div class="d-flex justify-content-between align-items-center mb-6">
        <h1 class="fs-3 fw-bold text-dark">Kết quả tìm kiếm</h1>
        <form class="search-form d-flex" action="{{ route('san-pham.search') }}" method="GET">
            <input class="form-control me-2 search-input" type="search" name="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" value="{{ $search ?? '' }}">
            <button class="btn search-btn" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <!-- Thông báo -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Danh sách sản phẩm -->
    <div class="row">
        @if ($sanPhams->isEmpty())
            <div class="col-12 text-center">
                <p class="text-muted fs-5">Không tìm thấy sản phẩm nào!</p>
            </div>
        @else
            @foreach ($sanPhams as $sanPham)
                <div class="col-md-4 mb-5">
                    <div class="card h-300 product-card shadow-sm ">
                        <img src="{{ asset($sanPham->anh) }}" class="card-img-top product-image" alt="{{ $sanPham->ten_san_pham }}">
                        <div class="card-body">
                            <h5 class="card-title product-title">{{ $sanPham->ten_san_pham }}</h5>
                            <p class="card-text text-accent fw-medium">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
                            <p class="card-text text-muted">Danh mục: {{ $sanPham->danhMuc->ten_danh_muc ?? 'N/A' }}</p>
                            <form action="{{ route('giohang.them', $sanPham->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-action w-100">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center mt-6">
        <nav aria-label="Page navigation">
            {{ $sanPhams->appends(['search' => $search, 'ma_danh_muc' => $ma_danh_muc])->links('pagination::bootstrap-5') }}
        </nav>
    </div>
</div>

<style>
    /* Thanh tìm kiếm */
    .search-form {
        position: relative;
    }
    .search-input {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 0.25rem 0 0 0.25rem;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .search-input:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }
    .search-btn {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
        border-left: none;
        border-radius: 0 0.25rem 0.25rem 0;
        padding: 0.375rem 0.75rem;
        transition: background-color 0.15s ease-in-out;
    }
    .search-btn:hover {
        background-color: #0056b3;
        color: white;
    }

    /* Sản phẩm */
    .product-card {
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    .product-image {
        height: 250px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }
    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    /* Nút hành động */
    .btn-action {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        transition: background-color 0.3s ease;
    }
    .btn-action:hover {
        background-color: #0056b3;
    }
    .text-accent {
        color: #dc3545;
        font-size: 1.1rem;
    }

    /* Phân trang */
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
    }
    .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }
    .page-link:hover {
        z-index: 2;
        color: #0056b3;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dee2e6;
    }
</style>
@endsection