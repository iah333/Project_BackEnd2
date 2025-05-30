@extends('layouts.admin')

@section('content')
    <style>
        .btn-custom {
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
        }

        .btn-back:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
    </style>
    <h1>Thêm Admin Mới</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Tên:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-control">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required class="form-control">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Xác nhận mật khẩu:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="form-control">
        </div>

        <div>
            <label for="avatar">Avatar:</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
            @error('avatar')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Tạo mới</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-back mt-3">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </form>
@endsection
