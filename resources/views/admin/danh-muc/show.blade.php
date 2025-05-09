@extends('layouts.app')

@section('title', $danhMuc->ten_danh_muc . ' - PhoneStore')

@section('content')
    <div class="container mt-4">
        <h1>Danh mục: {{ $danhMuc->ten_danh_muc }}</h1>

        @if ($danhMuc->sanPhams->isEmpty())
            <p>Chưa có sản phẩm nào trong danh mục này.</p>
        @else
            <div class="row">
                @foreach ($danhMuc->sanPhams as $sanPham)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if ($sanPham->anh)
                                <img src="{{ asset($sanPham->anh) }}" class="card-img-top" alt="{{ $sanPham->ten_san_pham }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top" alt="No image" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $sanPham->ten_san_pham }}</h5>
                                <p class="card-text"><strong>Giá:</strong> {{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
                                <p class="card-text"><strong>Số lượng tồn:</strong> {{ $sanPham->so_luong_ton }}</p>
                                <a href="{{ route('sanPham.show', $sanPham->ma_san_pham) }}" class="btn btn-primary">Xem chi tiết</a>                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection