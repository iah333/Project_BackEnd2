@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5>Thêm sản phẩm mới</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('sanPham.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="ten_san_pham" class="form-label">Tên sản phẩm</label>
                <input type="text" name="ten_san_pham" class="form-control" value="{{ old('ten_san_pham') }}" required>
            </div>
            <div class="mb-3">
                <label for="gia" class="form-label">Giá</label>
                <input type="number" name="gia" class="form-control" value="{{ old('gia') }}" required>
            </div>
            <div class="mb-3">
                <label for="so_luong_ton" class="form-label">Số lượng tồn</label>
                <input type="number" name="so_luong_ton" class="form-control" value="{{ old('so_luong_ton') }}" required>
            </div>
            <div class="mb-3">
                <label for="ma_danh_muc" class="form-label">Danh mục</label>
                <select name="ma_danh_muc" class="form-control" required>
                    <option value="">Chọn danh mục</option>
                    @foreach ($danhMucs as $danhMuc)
                        <option value="{{ $danhMuc->ma_danh_muc }}" {{ old('ma_danh_muc') == $danhMuc->ma_danh_muc ? 'selected' : '' }}>{{ $danhMuc->ten_danh_muc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="anh" class="form-label">Ảnh sản phẩm</label>
                <input type="file" name="anh" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </form>
    </div>
</div>
@endsection