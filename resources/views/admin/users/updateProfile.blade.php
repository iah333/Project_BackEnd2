@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0"
        style="background: url('https://via.placeholder.com/1200x600') no-repeat center center; background-size: cover; min-height: 600px;">
        <div class="row justify-content-end">
            <div class="col-md-4 bg-white p-4 mt-5 mr-5 rounded shadow" style="opacity: 0.9;">
                <h2 class="text-center mb-4">CẬP NHẬT TÀI KHOẢN</h2>
                <h5 class="text-center mb-4">Cập nhật thông tin của bạn!</h5>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-4">
                        <img src="{{ asset($user->avatar ?? 'avatar/default.jpg') }}" alt="Avatar" class="rounded-circle"
                            id="previewAvatar" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên tài khoản:</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Điện thoại:</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Ảnh đại diện:</label>
                        <input type="file" name="avatar" class="form-control" id="avatarInput" accept="image/*">
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('users.profile') }}" class="btn btn-secondary ms-2">Quay lại</a>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('user.profile.update') }}" class="btn btn-primary">Change Password</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('previewAvatar');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
