@extends('layouts.app')

@section('title', 'Trang tài khoản')

@section('content')
    <div class="container py-4">
        <div class="row">
            {{-- Sidebar trái --}}
            <div class="col-md-3">
                <h4 class="mb-3">TRANG TÀI KHOẢN</h4>
                <p>Xin chào, <strong>{{ $user->name }}</strong> !</p>

                <ul class="list-unstyled">
                    <li><a href="{{ route('users.account') }}" class="text-dark">Thông tin tài khoản</a></li>
                    <li>Số địa chỉ</li>
                    <li><a href="">Đăng xuất</a></li>
                </ul>
            </div>

            {{-- Nội dung bên phải --}}
            <div class="col-md-9 border-start ps-4">
                <h5 class="mb-3">TÀI KHOẢN</h5>
                <p><strong>Tên tài khoản:</strong> {{ $user->name }}</p>
                <p><strong>Địa chỉ:</strong>
                </p>
                <p><strong>Điện thoại:</strong></p>

                <hr>

                <h5 class="mt-4 mb-3">ĐƠN HÀNG CỦA BẠN</h5>
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Thành tiền</th>
                            <th>TT thanh toán</th>
                            <th>TT vận chuyển</th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        @forelse ($user->donhangs as $donhang)
    <tr>
                            <td>#{{ $donhang->id }}</td>
                            <td>{{ $donhang->ngay_dat->format('d/m/Y') }}</td>
                            <td>{{ number_format($donhang->tong_tien, 0, ',', '.') }} đ</td>
                            <td>Đã thanh toán</td>
                            <td>{{ $donhang->trang_thai }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Không có đơn hàng nào.</td>
                        </tr>
    @endforelse
                    </tbody> -->
                </table>
            </div>
        </div>
    </div>
@endsection
