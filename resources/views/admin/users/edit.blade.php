@extends('layouts.admin')

@section('content')
    <h1>Cập nhật người dùng</h1>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label>Tên:</label>
        <input type="text" name="name" value="{{ $user->name }}" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" required><br>

        <label>Password mới (nếu đổi):</label>
        <input type="password" name="password"><br>

        <label>Avatar:</label>
        <input type="file" name="avatar"><br>
        @if ($user->avatar)
            <img src="{{ asset('avatar/' . $user->avatar) }}" width="100">
        @endif

        <button type="submit">Cập nhật</button>
    </form>
@endsection
