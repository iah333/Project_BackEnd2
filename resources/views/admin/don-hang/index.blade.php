@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <!-- Tiêu đề và thông báo -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-dark">Danh sách đơn hàng</h1>
            <a href="{{ route('admin.donhang.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-sync-alt me-2"></i>Tải lại
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Bảng đơn hàng -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col" class="ps-4">ID</th>
                                <th scope="col">Tên người nhận</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col" class="text-end pe-4">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($donHangs as $donHang)
                                <tr>
                                    <td class="ps-4">{{ $donHang->id }}</td>
                                    <td>{{ $donHang->ten_nguoi_nhan }}</td>
                                    <td>{{ $donHang->so_dien_thoai }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $donHang->trang_thai == 'Đã giao' ? 'bg-success' : ($donHang->trang_thai == 'Hủy' ? 'bg-danger' : ($donHang->trang_thai == 'Đang giao' ? 'bg-warning' : 'bg-secondary')) }}">
                                            {{ $donHang->trang_thai }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($donHang->ngay_dat)->format('d/m/Y') }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.donhang.show', $donHang->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye me-1"></i>Xem
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Không có đơn hàng nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-4">
            {{ $donHangs->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Thêm Font Awesome cho icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('styles')
    <style>
        /* Tùy chỉnh giao diện */
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
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
            padding: 0.5em 1em;
            border-radius: 20px;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            border-radius: 5px;
        }

        .alert {
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .pagination .page-link {
            border-radius: 5px;
            margin: 0 3px;
            color: #007bff;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
        }
    </style>
@endsection
