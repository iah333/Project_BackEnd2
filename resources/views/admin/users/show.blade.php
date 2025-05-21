@extends('layouts.admin')

@section('content')
    <h1>Thông tin người dùng</h1>
    <p><strong>ID:</strong> {{ $user->id }}</p>
    <p><strong>Tên:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Admin:</strong> {{ $user->is_admin ? '✔️' : '❌' }}</p>
    <img src="{{ asset('avatar/' . (auth()->user()->avatar ?? 'default.jpg')) }}" class="profile-avatar" alt="Avatar">
    <a href="{{ route('admin.users.index') }}">Quay lại danh sách</a>
@endsection
