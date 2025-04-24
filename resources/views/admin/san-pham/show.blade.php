@extends('layouts.app')

@section('title', $sanPham->ten_san_pham . ' - PhoneStore')

@section('content')
    <div class="container mt-4">
        <h1>{{ $sanPham->ten_san_pham }}</h1>
        <div class="row">
            <div class="col-md-6">
                @if ($sanPham->anh)
                    <img src="{{ asset($sanPham->anh) }}" class="img-fluid" alt="{{ $sanPham->ten_san_pham }}">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid" alt="No image">
                @endif
            </div>
            <div class="col-md-6">
                <p><strong>Giá:</strong> {{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
                <p><strong>Số lượng tồn:</strong> {{ $sanPham->so_luong_ton }}</p>
                <p><strong>Danh mục:</strong> {{ $sanPham->danhMuc->ten_danh_muc }}</p>
                <a href="{{ route('danh-muc.slug', $sanPham->danhMuc->ten_danh_muc) }}" class="btn btn-secondary">Quay lại danh mục</a>
            </div>
        </div>
    </div>
@endsection