@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5>Thêm danh mục</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('danhMuc.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="ten_danh_muc" class="form-label">Tên danh mục</label>
                <input type="text" name="ten_danh_muc" id="ten_danh_muc" class="form-control" value="{{ old('ten_danh_muc') }}">
                @error('ten_danh_muc')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('danhMuc.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection