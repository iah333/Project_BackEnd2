@extends('layouts.app')

@section('content')
    <main class="signup-form min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white text-center py-3">
                            <h3 class="mb-0">Đăng Ký</h3>
                        </div>
                        <div class="card-body p-4">
                            <!-- Thông báo từ session -->
                            @if (session('msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('msg') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-medium">Tên</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control border-start-0 @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Nhập tên của bạn"
                                            value="{{ old('name') }}" required autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email_address" class="form-label fw-medium">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email"
                                            class="form-control border-start-0 @error('email') is-invalid @enderror"
                                            id="email_address" name="email" placeholder="Nhập email của bạn"
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-medium">Mật khẩu</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password"
                                            class="form-control border-start-0 @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Nhập mật khẩu" required>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-medium">Xác nhận mật
                                        khẩu</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password"
                                            class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" name="password_confirmation"
                                            placeholder="Xác nhận mật khẩu" required>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Remember Me -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-dark btn-block fw-medium">
                                        <i class="fas fa-user-plus me-2"></i>Đăng Ký
                                    </button>
                                </div>

                                <!-- Quay lại đăng nhập -->
                                <div class="text-center">
                                    <a href="{{ route('login.form') }}" class="text-decoration-none text-muted small">Quay
                                        lại đăng nhập?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        // Xóa thông báo session sau 5 giây
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 150);
                }, 5000);
            }
        });
    </script>
@endsection
