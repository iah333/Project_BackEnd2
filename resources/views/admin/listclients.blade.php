@extends('layouts.admin')
@section('content')
<h5 class="danhSach">Danh sách user</h5>
    <main class="login-form">
        <div class="container">
            <div class="row justify-content-center">

                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ Session::get('success') }}
                    </div>
                @endif


                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Chức năng</th>
                            <th>Ảnh</th>

                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th>{{ $user->name }}</th>
                                <th>{{ $user->email }}</th>
                                <th>{{ $user->phone }}</th>
                                <th>{{ $user->address }}</th>
                                <th>{{ $user->is_admin }}</th>
                                <img src="{{ asset('uploads/' . (auth()->user()->picture ?? 'default.jpg')) }}" class="profile-avatar" alt="Avatar">
                                <th>
                                    <a href="" >View</a> |
                                    <a href="" >Edit</a> |
                                    <a href="" >Delete</a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="text-align: center;" class="link">{{ $users->links() }}</div>
        </div>
    </main>
@endsection