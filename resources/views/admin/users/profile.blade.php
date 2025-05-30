@extends('layouts.app')

@section('title', 'Hồ sơ người dùng - PhoneStore')

@section('content')
    <div class="container mx-auto my-6 px-4">
        <!-- Tiêu đề -->
        <h1 class="fs-3 fw-bold text-dark mb-4">Hồ sơ của {{ $user->name }}</h1>

        <!-- Thông tin người dùng -->
        <div class="bg-white p-4 rounded border shadow-sm mb-4">
            <h6 class="fs-6 fw-bold text-dark mb-3">Thông tin cá nhân</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="text-muted"><strong>Tên:</strong> {{ $user->name }}</p>
                    <p class="text-muted"><strong>Email:</strong> {{ $user->email }}</p>
                    @if ($user->avatar)
                        <p class="text-muted"><strong>Ảnh đại diện:</strong> <img src="{{ asset($user->avatar) }}"
                                alt="Avatar" style="width: 100px; height: 100px;"></p>
                    @else
                        <p class="text-muted"><strong>Ảnh đại diện:</strong> Chưa có ảnh</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <a href="{{ route('profile.editU', $user->id) }}" class="btn btn-primary mb-3">Chỉnh sửa hồ
                        sơ</a>
                    <a href="{{ route('change.form', $user->id) }}" class="btn btn-primary mb-3">
                        <i class="fas fa-key"></i> Đổi mật khẩu
                    </a>
                </div>
            </div>
        </div>

        <!-- Địa chỉ của người dùng -->
        <div class="bg-white p-4 rounded border shadow-sm mb-4">
            <h6 class="fs-6 fw-bold text-dark mb-3">Địa chỉ của bạn</h6>
            @if ($addresses->isEmpty())
                <p class="text-muted">Bạn chưa thêm địa chỉ nào. <a href="{{ route('user.addresses') }}"
                        class="text-accent">Thêm địa chỉ ngay</a></p>
            @else
                <div class="list-group">
                    @foreach ($addresses as $address)
                        <div class="list-group-item">
                            <p class="mb-1">{{ $address->dia_chi_chi_tiet }},
                                {{ $address->phuongXa->ten_phuong_xa ?? 'N/A' }},
                                {{ $address->quanHuyen->ten_quan_huyen ?? 'N/A' }},
                                {{ $address->thanhPho->ten_thanh_pho ?? 'N/A' }}</p>
                            <small class="text-muted">ID: {{ $address->id }}</small>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('dia-chi.index') }}" class="btn btn-primary mb-3">Quản lí địa chỉ</a>
                {{-- <a href="{{ route('dia-chi.addresses.index') }}" class="btn btn-outline-accent mt-3">Quản lý địa chỉ</a> --}}
            @endif
        </div>

        <!-- Giỏ hàng của người dùng -->
        <div class="bg-white p-4 rounded border shadow-sm">
            <h6 class="fs-6 fw-bold text-dark mb-3">Giỏ hàng của bạn</h6>
            @if ($cartItems->isEmpty())
                <p class="text-muted">Giỏ hàng của bạn đang trống. <a href="{{ route('sanPham.index') }}"
                        class="text-accent">Mua sắm ngay</a></p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset($item->anh) }}" alt="{{ $item->ten_san_pham }}"
                                            style="width: 50px; height: 50px;" class="me-2 rounded">
                                        {{ $item->ten_san_pham }}
                                    </td>
                                    <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $item->pivot->so_luong }}</td>
                                    <td>{{ number_format($item->gia * $item->pivot->so_luong, 0, ',', '.') }} VNĐ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-muted mt-3"><strong>Tổng số lượng:</strong> {{ $tongSoLuong }}</p>
                <p class="text-muted"><strong>Tổng giá:</strong> <span
                        class="text-accent fw-medium">{{ number_format($tongGia, 0, ',', '.') }} VNĐ</span></p>
                <a href="{{ route('giohang.index') }}" class="btn btn-primary mb-3">Xem giỏ hàng</a>
            @endif
        </div>
    </div>
@endsection
