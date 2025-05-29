@extends('layouts.admin')

@section('content')
    <style>
        .profile-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: linear-gradient(145deg, #ffffff, #f0f2f5);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .profile-container:hover {
            transform: translateY(-5px);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 25px;
        }

        .profile-header img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #007bff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .profile-header img:hover {
            transform: scale(1.05);
        }

        .profile-info h2 {
            margin: 0 0 10px;
            font-size: 30px;
            font-weight: 700;
            color: #2c3e50;
        }

        .profile-info p {
            margin: 6px 0;
            color: #495057;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-details {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .profile-details p {
            margin: 12px 0;
            font-size: 16px;
            color: #343a40;
        }

        .profile-details p strong {
            color: #007bff;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 30px;
            justify-content: center;
        }

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

        .btn-edit {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-edit:hover {
            background-color: #218838;
            transform: translateY(-2px);
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

        @media (max-width: 768px) {
            .profile-container {
                margin: 20px;
                padding: 20px;
            }

            .profile-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .profile-header img {
                width: 100px;
                height: 100px;
            }

            .profile-info h2 {
                font-size: 24px;
            }

            .profile-info p {
                font-size: 14px;
            }
        }
    </style>

    <!-- Thêm SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="profile-container">
        <div class="profile-header">
            <img src="{{ asset(auth()->user()->avatar ?? 'avatar/default.jpg') }}">
            <div class="profile-info">
                <h2>{{ $user->name }}</h2>
                <p><i class="fas fa-envelope"></i> Email: {{ $user->email }}</p>
                <p>
                    <i
                        class="fas {{ $user->super_admin ? 'fa-shield-alt' : ($user->is_admin ? 'fa-crown' : 'fa-user') }}"></i>
                    Vai trò: {{ $user->super_admin ? 'Super Admin' : ($user->is_admin ? 'Admin' : 'Người dùng') }}
                </p>
            </div>
        </div>

        <div class="profile-details">
            <p><strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="btn-group">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-custom btn-edit">
                <i class="fas fa-edit"></i> Chỉnh sửa
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn-custom btn-back">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
@endsection
