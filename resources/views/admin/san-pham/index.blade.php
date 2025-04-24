@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Danh sách sản phẩm</h5>
        <a href="{{ route('sanPham.create') }}" class="btn btn-primary">Thêm sản phẩm</a>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Số lượng tồn</th>
                    <th>Ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sanPhams as $sanPham)
                    <tr>
                        <td>{{ $sanPham->ma_san_pham }}</td>
                        <td>{{ $sanPham->ten_san_pham }}</td>
                        <td>{{ $sanPham->danhMuc->ten_danh_muc }}</td>
                        <td>{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</td>
                        <td>{{ $sanPham->so_luong_ton }}</td>
                        <td>
                            @if ($sanPham->anh)
                                <img src="{{ asset($sanPham->anh) }}" alt="{{ $sanPham->ten_san_pham }}" style="width: 50px;">
                            @else
                                Không có
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('sanPham.edit', $sanPham->ma_san_pham) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('sanPham.destroy', $sanPham->ma_san_pham) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection