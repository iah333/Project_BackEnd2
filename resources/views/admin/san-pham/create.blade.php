@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5>Thêm sản phẩm mới</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
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
                <input type="text" name="ten_san_pham" id="ten_san_pham" class="form-control" value="{{ old('ten_san_pham') }}" required>
                @error('ten_san_pham')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gia" class="form-label">Giá</label>
                <input type="number" name="gia" id="gia" class="form-control" value="{{ old('gia') }}" step="0.01" min="0" required>
                @error('gia')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="so_luong_ton" class="form-label">Số lượng tồn</label>
                <input type="number" name="so_luong_ton" id="so_luong_ton" class="form-control" value="{{ old('so_luong_ton') }}" min="0" required>
                @error('so_luong_ton')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="danhmuc_id" class="form-label">Danh mục</label>
                <select name="danhmuc_id" id="danhmuc_id" class="form-control" required>
                    <option value="">Chọn danh mục</option>
                    @foreach ($danhMucs as $danhMuc)
                        <option value="{{ $danhMuc->id }}" {{ old('danhmuc_id') == $danhMuc->id ? 'selected' : '' }}>
                            {{ $danhMuc->ten_danh_muc }}
                        </option>
                    @endforeach
                </select>
                @error('danhmuc_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="anh" class="form-label">Ảnh sản phẩm</label>
                <input type="file" name="anh" id="anh" class="form-control" accept="image/jpeg,image/png,image/jpg">
                @error('anh')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                <a href="{{ route('sanPham.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection