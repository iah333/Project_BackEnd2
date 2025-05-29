@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-primary">Cập nhật người dùng</h2>

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data"
            class="bg-white shadow-sm rounded p-4">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu mới (nếu muốn thay đổi)</label>
                <input type="password" name="password" class="form-control" placeholder="Để trống nếu không thay đổi">
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh đại diện (avatar)</label>
                <input type="file" name="avatar" class="form-control">
                @if ($user->avatar)
                    <div class="mt-2">
                        <img src="{{ asset(auth()->user()->avatar ?? 'avatar/default.jpg') }}" alt="avatar" width="100"
                            height="100">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Cập nhật
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Quay lại</a>
        </form>
    </div>
@endsection
