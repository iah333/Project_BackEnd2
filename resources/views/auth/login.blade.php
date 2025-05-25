@extends('layouts.app')

@section('content')
    <main class="login-form min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white text-center py-3">
                            <h3 class="mb-0">Đăng Nhập</h3>
                        </div>
                        <div class="card-body p-4">

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-medium">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email"
                                            class="form-control border-start-0 @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Nhập email của bạn"
                                            value="{{ old('email') }}" required autofocus>
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

                                <!-- Remember Me -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-dark btn-block fw-medium">
                                        <i class="fas fa-sign-in-alt me-2"></i>Đăng Nhập
                                    </button>
                                </div>

                                <!-- Quên mật khẩu và đăng ký -->
                                <div class="text-center">

                                    <span class="text-muted mx-2">|</span>
                                    <a href="{{ route('register.form') }}"
                                        class="text-decoration-none text-primary small">Đăng ký tài khoản mới</a>
                                </div>
                            </form>
                            <!-- Thông báo từ session -->
                            @if (session('msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('msg') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Tùy chỉnh CSS cho form để khớp với giao diện */
        .login-form {
            background: linear-gradient(135deg, #e6f0fa 0%, #f8f9fa 100%);
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card-header {
            background-color: #515154;
            border-bottom: none;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-header h3 {
            font-weight: 500;
            color: rgba(255, 255, 255, 1);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
            color: #515154;
        }

        .form-control {
            background-color: #f8f9fa;
            border-color: #ced4da;
            color: #333;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(81, 81, 84, 0.25);
            border-color: #515154;
            background-color: #fff;
        }

        .form-control::placeholder {
            color: #6c757d;
        }

        .btn-dark {
            background-color: #515154;
            border-color: #515154;
            transition: background-color 0.3s ease;
        }

        .btn-dark:hover {
            background-color: #3c3c3f;
            border-color: #3c3c3f;
        }

        .small {
            font-size: 0.875rem;
        }

        .text-primary {
            color: #0d6efd !important;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .col-md-5.col-lg-4 {
                padding: 0 15px;
            }

            .card {
                border-radius: 0;
                box-shadow: none;
            }

            .card-header {
                border-radius: 0;
            }
        }
    </style>

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
