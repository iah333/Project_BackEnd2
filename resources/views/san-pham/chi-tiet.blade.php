@extends('layouts.app')

@section('title', $sanPham->ten_san_pham . ' - PhoneStore')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">{{ $sanPham->ten_san_pham }}</h1>
        <div class="row">
            <div class="col-md-6">
                @if ($sanPham->anh)
                    <img src="{{ asset($sanPham->anh) }}" class="img-fluid" alt="{{ $sanPham->ten_san_pham }}" style="max-height: 400px; object-fit: cover;">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid" alt="No image" style="max-height: 400px; object-fit: cover;">
                @endif
            </div>
            <div class="col-md-6 text-center">
                <p><strong>Giá:</strong> {{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
                <p><strong>Danh mục:</strong> {{ $sanPham->danhMuc->ten_danh_muc }}</p>
                <p><strong>Số lượng tồn:</strong> {{ $sanPham->so_luong_ton }}</p>
                <form action="{{ route('gioHang.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ma_san_pham" value="{{ $sanPham->ma_san_pham }}">
                    <label for="so_luong" class="d-block mb-2">Số lượng:</label>
                    <input type="number" name="so_luong" value="1" min="1" max="{{ $sanPham->so_luong_ton }}" class="form-control w-25 d-inline-block mb-3">
                    <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
    </div>
@endsectiond