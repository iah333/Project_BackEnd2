@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h5 class="mb-4">Danh sách user</h5>

        @if (Session::has('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ Session::get('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Chức năng</th>
                            <th>Ảnh</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <th>
                                    @if ($user->is_admin)
                                        <span style="color: green; font-weight: bold;">Admin</span>
                                    @else
                                        <span style="color: gray;">User</span>
                                    @endif
                                </th>

                                <td>
                                    <img src="{{ asset('avatar/' . $user->avatar) }}" width="50" height="50"
                                        alt="avatar">
                                </td>
                                <td>
                                    <a href="" {{ $user->id }} class="btn btn-info btn-sm">Xem</a>
                                    <a href="" {{ $user->id }} class="btn btn-warning btn-sm">Sửa</a>
                                    <form action="" {{ $user->id }} method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection
