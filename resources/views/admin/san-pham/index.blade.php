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
                    <th>Ảnh sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng tồn</th>
                    <th>Danh mục</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sanPhams as $sanPham)
                    <tr>
                        <td>{{ $sanPham->id }}</td>
                        <td>
                            @if ($sanPham->anh)
                                <!-- Loại bỏ phần "img/" thừa nếu có trong $sanPham->anh -->
                                @php
                                    $imagePath = str_replace('img/', '', $sanPham->anh); // Loại bỏ "img/" nếu có
                                @endphp
                                <img src="{{ asset('img/' . $imagePath) }}" alt="{{ $sanPham->ten_san_pham }}" style="width: 50px; height: auto;">
                            @else
                                <span>Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ $sanPham->ten_san_pham }}</td>
                        <td>{{ $sanPham->gia }}</td>
                        <td>{{ $sanPham->so_luong_ton }}</td>
                        <td>{{ $sanPham->danhMuc->ten_danh_muc ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('sanPham.edit', ['sanpham' => $sanPham->id]) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('sanPham.destroy', ['sanpham' => $sanPham->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Không có sản phẩm nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection