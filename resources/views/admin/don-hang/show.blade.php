@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <!-- Tiêu đề -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-dark">Chi tiết đơn hàng #{{ $donHang->id }}</h1>
            <a href="{{ route('admin.donhang.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>

        <!-- Thông báo thành công -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Thông tin đơn hàng -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h4 class="card-title text-primary mb-4">Thông tin đơn hàng</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Tên người nhận:</strong> {{ $donHang->ten_nguoi_nhan }}</p>
                        <p class="mb-2"><strong>Số điện thoại:</strong> {{ $donHang->so_dien_thoai }}</p>
                        <p class="mb-2">
                            <strong>Địa chỉ:</strong>
                            {{ $donHang->diaChi->dia_chi_chi_tiet }},
                            {{ $donHang->diaChi->phuongXa->ten_phuong_xa }},
                            {{ $donHang->diaChi->quanHuyen->ten_quan_huyen }},
                            {{ $donHang->diaChi->thanhPho->ten_thanh_pho }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Trạng thái:</strong>
                            <span
                                class="badge {{ $donHang->trang_thai == 'Đã giao' ? 'bg-success' : ($donHang->trang_thai == 'Hủy' ? 'bg-danger' : ($donHang->trang_thai == 'Đang giao' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
                                {{ $donHang->trang_thai }}
                            </span>
                        </p>
                        <p class="mb-2"><strong>Tổng tiền:</strong> {{ number_format($donHang->tong_tien, 0, ',', '.') }}
                            VNĐ</p>
                        <p class="mb-2"><strong>Ngày đặt:</strong>
                            {{ \Carbon\Carbon::parse($donHang->ngay_dat)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h4 class="card-title text-primary mb-4">Danh sách sản phẩm</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col" class="ps-4">Tên sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($donHang->chiTietDonHangs as $chiTiet)
                                <tr>
                                    <td class="ps-4">{{ $chiTiet->sanPham->ten_san_pham }}</td>
                                    <td>{{ $chiTiet->so_luong }}</td>
                                    <td>{{ number_format($chiTiet->gia, 0, ',', '.') }} VNĐ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Không có sản phẩm nào trong đơn hàng.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Form cập nhật trạng thái -->
        @if (Auth::user()->is_admin || Auth::user()->super_admin)
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="card-title text-primary mb-4">Cập nhật trạng thái</h4>
                    <form action="{{ route('admin.donhang.updateStatus', $donHang->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="trang_thai" class="form-label fw-bold">Trạng thái đơn hàng</label>
                            <select name="trang_thai" id="trang_thai" class="form-select">
                                <option value="chờ thanh toán khi nhận hàng"
                                    {{ $donHang->trang_thai == 'chờ thanh toán khi nhận hàng' ? 'selected' : '' }}>
                                    Chờ thanh toán khi nhận hàng
                                </option>
                                <option value="Đang giao" {{ $donHang->trang_thai == 'Đang giao' ? 'selected' : '' }}>
                                    Đang giao
                                </option>
                                <option value="Đã giao" {{ $donHang->trang_thai == 'Đã giao' ? 'selected' : '' }}>
                                    Đã giao
                                </option>
                                <option value="Hủy" {{ $donHang->trang_thai == 'Hủy' ? 'selected' : '' }}>
                                    Hủy
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-2"></i>Cập nhật
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- Font Awesome cho icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('styles')
    <style>
        /* Tùy chỉnh giao diện */
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .card {
            border-radius: 0.75rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05rem;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
            transition: background-color 0.2s ease;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.4em 0.9em;
            border-radius: 1rem;
            font-weight: 500;
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.85rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }

        .btn-sm:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 0.5rem;
            font-size: 0.9rem;
            padding: 1rem 1.5rem;
        }

        .form-select {
            border-radius: 0.25rem;
            font-size: 0.9rem;
        }

        .form-label {
            font-size: 0.9rem;
            color: #333;
        }
    </style>
@endsection
