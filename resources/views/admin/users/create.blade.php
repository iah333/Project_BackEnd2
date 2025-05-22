@extends('layouts.admin')

@section('content')
    <h1>Thêm người dùng mới</h1>

    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @csrf
        <label>Tên:</label>
        <input type="text" name="name" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Avatar:</label>
        <input type="file" name="avatar"><br>

        <button type="submit">Tạo mới</button>
    </form>
@endsection
