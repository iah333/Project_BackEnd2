@extends('layouts.app')

@section('title', $danhMuc->ten_danh_muc . ' - PhoneStore')

@section('content')
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
@endsection