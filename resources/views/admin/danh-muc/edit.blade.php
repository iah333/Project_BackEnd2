@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5>Sửa danh mục</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('danhMuc.update', $danhMuc->ma_danh_muc) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="ten_danh_muc" class="form-label">Tên danh mục</label>
                <input type="text" name="ten_danh_muc" id="ten_danh_muc" class="form-control" value="{{ old('ten_danh_muc', $danhMuc->ten_danh_muc) }}">
                @error('ten_danh_muc')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('danhMuc.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection