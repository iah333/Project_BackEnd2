@extends('layouts.admin')

@section('content')
<style>
    .profile-card {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #007bff;
        margin-bottom: 20px;
    }

    .profile-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 30px;
        color: #007bff;
    }

    .profile-info p {
        margin-bottom: 10px;
        font-size: 16px;
    }

    .edit-button {
        margin-top: 30px;
    }
</style>

<div class="container">
    <div class="profile-card text-center">
        <img src="{{ asset('uploads/' . (auth()->user()->picture ?? 'default.jpg')) }}" class="profile-avatar" alt="Avatar">
        <div class="profile-title">Thông tin cá nhân</div>

        <div class="profile-info text-start px-4">
            <p><strong>Họ tên:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ auth()->user()->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ auth()->user()->address }}</p>
        </div>

        <a href="{{ 'admin/update'}}" class="btn btn-primary edit-button">Chỉnh sửa</a>
    </div>
</div>
@endsection
