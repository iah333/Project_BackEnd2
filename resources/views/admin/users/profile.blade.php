<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <title>Thông Tin Cá Nhân - PhoneStore</title>
    <style>
        .user-avatar {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }

        .card-header {
            background-color: #515154;
            color: white;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-custom {
            background-color: #515154;
            color: white;
        }

        .btn-custom:hover {
            background-color: #3c3c3f;
            color: white;
        }
    </style>
</head>

<body>
    @extends('layouts.app') <!-- Kế thừa từ layout chính đã cung cấp -->

    @section('content')
        <div class="container my-5">
            <h2 class="mb-4 text-center">Thông Tin Cá Nhân</h2>

            <!-- Thông báo thành công hoặc lỗi -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Thông tin cá nhân -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Hồ Sơ</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img src="{{ asset('avatar/' . $user->avatar ?? 'default.jpg') }}" class="user-avatar mb-3"
                                alt="Avatar">
                        </div>
                        <div class="col-md-9">
                            <p><strong>Họ tên:</strong> {{ auth()->user()->name }}</p>
                            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="fas fa-edit"></i> Chỉnh sửa hồ sơ
                            </button>
                            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fas fa-edit"></i> Đổi mật khẩu
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal đổi mật khẩu -->
            <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changePasswordModalLabel">Đổi mật khẩu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <form action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                    <input type="password" class="form-control" id="current_password"
                                        name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        name="new_password_confirmation" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-custom">Đổi mật khẩu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal chỉnh sửa hồ sơ -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProfileModalLabel">Chỉnh sửa hồ sơ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ tên</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ auth()->user()->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ auth()->user()->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar"
                                        accept="image/*">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-custom">Lưu thay đổi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Danh sách địa chỉ -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh Sách Địa Chỉ</h5>
                </div>
                <div class="card-body">
                    @if ($addresses->isEmpty())
                        <p>Chưa có địa chỉ nào.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên người nhận</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addresses as $address)
                                    <tr>
                                        <td>{{ $address->ten_nguoi_nhan }}</td>
                                        <td>{{ $address->so_dien_thoai }}</td>
                                        <td>{{ $address->dia_chi_chi_tiet }}, {{ $address->phuong_xa->ten_phuong_xa }},
                                            {{ $address->quan_huyen->ten_quan_huyen }},
                                            {{ $address->thanh_pho->ten_thanh_pho }}</td>
                                        <td>
                                            <a href="{{ route('dia-chi.edit', $address->id) }}"
                                                class="btn btn-sm btn-custom">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <form action="{{ route('dia-chi.destroy', $address->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc muốn xóa địa chỉ này?')">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <a href="{{ route('dia-chi.create') }}" class="btn btn-custom">
                        <i class="fas fa-plus"></i> Thêm địa chỉ mới
                    </a>
                </div>
            </div>

            <!-- Giỏ hàng -->
            <!-- Giỏ hàng -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Giỏ Hàng</h5>
                </div>
                <div class="card-body">
                    @if ($cartItems->isEmpty())
                        <p>Giỏ hàng trống.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td>{{ $item->ten_san_pham }}</td>
                                        <td>{{ $item->pivot->so_luong }}</td>
                                        <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                                        <td>{{ number_format($item->pivot->so_luong * $item->gia, 0, ',', '.') }} VNĐ</td>
                                        <td>
                                            <form action="{{ route('gioHang.update', $item->pivot->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="so_luong"
                                                    value="{{ $item->pivot->so_luong }}" min="1"
                                                    class="form-control d-inline w-auto">
                                                <button type="submit" class="btn btn-sm btn-custom">
                                                    <i class="fas fa-sync"></i> Cập nhật
                                                </button>
                                            </form>
                                            <form action="{{ route('gioHang.remove', $item->pivot->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('gioHang.index') }}" class="btn btn-custom">
                            <i class="fas fa-shopping-cart"></i> Xem giỏ hàng chi tiết
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
