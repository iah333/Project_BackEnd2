@extends('layouts.admin')

@section('content')
    <style>
        .change-password-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: linear-gradient(145deg, #ffffff, #f0f2f5);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .change-password-container:hover {
            transform: translateY(-5px);
        }

        .change-password-container h2 {
            text-align: center;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #343a40;
            margin-bottom: 8px;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 16px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        .success-message {
            color: #28a745;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
            display: block;
        }

        .general-message {
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .change-password-container {
                margin: 20px;
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }

            .form-group input {
                font-size: 14px;
            }
        }
    </style>

    <div class="change-password-container">
        <h2>Đổi mật khẩu</h2>

        <!-- Hiển thị thông báo thành công or lỗi chung -->
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="general-message error-message">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.change.password') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="form-group">
                <label for="old_password">Mật khẩu cũ</label>
                <input type="password" name="old_password" id="old_password" class="form-control" required>
                @error('old_password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password">Mật khẩu mới</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
                @error('new_password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control"
                    required>
                @error('new_password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Đổi mật khẩu</button>
        </form>

        <a href="{{ route('admin.users.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
@endsection
