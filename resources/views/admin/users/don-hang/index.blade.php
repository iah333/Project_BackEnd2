@extends('layouts.appsub')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <!-- Tiêu đề -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Danh sách đơn hàng của bạn</h2>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Quay lại trang chủ</a>
                </div>

                <!-- Thông báo khi không có đơn hàng -->
                @if ($donHangs->isEmpty())
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-cart-x-fill text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-3 fs-5 text-muted">Bạn chưa có đơn hàng nào.</p>
                        </div>
                    </div>
                @else
                    <!-- Bảng danh sách đơn hàng -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Mã đơn hàng</th>
                                            <th scope="col">Người nhận</th>
                                            <th scope="col">Số điện thoại</th>
                                            <th scope="col">Địa chỉ</th>
                                            <th scope="col">Tổng tiền</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Ngày đặt</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($donHangs as $donHang)
                                            <tr>
                                                <td>#{{ $donHang->id }}</td>
                                                <td>{{ $donHang->ten_nguoi_nhan }}</td>
                                                <td>{{ $donHang->so_dien_thoai }}</td>
                                                <td>{{ $donHang->diaChi->dia_chi_day_du ?? 'Chưa cập nhật' }}</td>
                                                <td>{{ number_format($donHang->tong_tien, 0, ',', '.') }}₫</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $donHang->trang_thai == 'chờ thanh toán khi nhận hàng' ? 'bg-warning' : ($donHang->trang_thai == 'Đang giao' ? 'bg-info' : ($donHang->trang_thai == 'Đã giao' ? 'bg-success' : 'bg-danger')) }}">
                                                        {{ $donHang->trang_thai }}
                                                    </span>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($donHang->ngay_dat)->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('user.don-hang.show', $donHang->id) }}"
                                                        class="btn btn-primary btn-sm" title="Xem chi tiết đơn hàng">
                                                        <i class="bi bi-eye"></i> Xem
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Phân trang -->
                    <div class="mt-4">
                        {{ $donHangs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Thêm Bootstrap Icons và CSS tùy chỉnh -->
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            .table th,
            .table td {
                vertical-align: middle;
            }

            .badge {
                font-size: 0.9rem;
                padding: 0.5em 1em;
            }

            .card {
                border-radius: 10px;
            }

            .table-hover tbody tr:hover {
                background-color: #f8f9fa;
            }

            @media (max-width: 576px) {
                .table {
                    font-size: 0.9rem;
                }

                .btn-sm {
                    padding: 0.3rem 0.6rem;
                }
            }
        </style>
    @endpush
@endsection
