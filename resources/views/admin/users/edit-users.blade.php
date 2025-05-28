@extends('layouts.app')

@section('title', 'Chỉnh sửa hồ sơ - PhoneStore')

@section('content')
    <div class="container mx-auto my-6 px-4">
        <!-- Tiêu đề -->
        <h1 class="fs-3 fw-bold text-dark mb-4">Chỉnh sửa hồ sơ</h1>

        <!-- Thông báo -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form chỉnh sửa thông tin người dùng -->
        <div class="bg-white p-4 rounded border shadow-sm">
            <h6 class="fs-6 fw-bold text-dark mb-4">Cập nhật thông tin cá nhân</h6>
            <form action="{{ route('profile.updateU') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Tên -->
                    <div class="col-md-6">
                        <label for="name" class="form-label text-muted">Tên</label>
                        <input type="text" name="name" id="name"
                            class="form-control border-accent @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label text-muted">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control border-accent @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mật khẩu -->
                    <div class="col-md-6">
                        <label for="password" class="form-label text-muted">Mật khẩu mới (để trống nếu không muốn thay
                            đổi)</label>
                        <input type="password" name="password" id="password"
                            class="form-control border-accent @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ảnh đại diện -->
                    <div class="col-md-6">
                        <label for="avatar" class="form-label text-muted">Ảnh đại diện</label>
                        <input type="file" name="avatar" id="avatar"
                            class="form-control border-accent @error('avatar') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/jpg">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($user->avatar)
                            <div class="mt-2">
                                <p class="text-muted">Ảnh hiện tại:</p>
                                <img src="{{ asset($user->avatar) }}" alt="Avatar" style="width: 100px; height: 100px;"
                                    class="rounded">
                            </div>
                        @else
                            <p class="text-muted mt-2">Chưa có ảnh đại diện.</p>
                        @endif
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="mt-4 d-flex gap-3">
                    <button type="submit" class="btn btn-primary px-4 py-2">Cập nhật</button>
                    <a href="{{ route('users.profile') }}" class="btn btn-outline-secondary px-4 py-2">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection
