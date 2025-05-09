@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Danh sách danh mục</h5>
        <a href="{{ route('danhMuc.create') }}" class="btn btn-primary">Thêm danh mục</a>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($danhMucs as $danhMuc)
                    <tr>
                        <td>{{ $danhMuc->ma_danh_muc }}</td>
                        <td>{{ $danhMuc->ten_danh_muc }}</td>
                        <td>
                            <a href="{{ route('danhMuc.edit', $danhMuc->ma_danh_muc) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('danhMuc.destroy', $danhMuc->ma_danh_muc) }}" method="POST" style="display:inline;">
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