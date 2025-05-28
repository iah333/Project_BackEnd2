@extends('layouts.app')

@section('title', 'Giỏ hàng - PhoneStore')

@section('content')
    <div class="container mx-auto my-6 px-4">
        <!-- Tiêu đề -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fs-3 fw-bold text-dark">Giỏ hàng</h1>
            <a href="{{ route('sanPham.index') }}" class="btn btn-outline-accent text-accent fw-medium">Tiếp tục mua sắm</a>
        </div>

        <!-- Hiển thị thông báo -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @php
            $cartItems = $cartItems ?? collect();
            $tongSoLuong = session('tongSoLuong') ?? ($tongSoLuong ?? 0);
            $tongGia = session('tongGia') ?? ($tongGia ?? 0);
        @endphp

        @if ($cartItems->isEmpty())
            <div class="bg-light p-5 rounded text-center border shadow-sm">
                <p class="text-muted fs-5">Giỏ hàng của bạn đang trống!</p>
                <a href="{{ route('sanPham.index') }}" class="btn btn-accent px-4 py-2 mt-3">Mua sắm ngay</a>
            </div>
        @else
            <!-- Form bao gồm toàn bộ giỏ hàng -->
            <form action="{{ route('don-hang.store') }}" method="POST" id="gioHangForm">
                @csrf
                <!-- Danh sách sản phẩm -->
                <div class="bg-white rounded border shadow-sm">
                    <!-- Header bảng -->
                    <div class="d-flex align-items-center p-3 border-bottom bg-light">
                        <span class="w-10 text-center text-muted fw-medium">Chọn</span>
                        <span class="w-10 text-center text-muted fw-medium">Ảnh</span>
                        <span class="w-20 text-center text-muted fw-medium">Đơn Giá</span>
                        <span class="w-20 text-center text-muted fw-medium">Số Lượng</span>
                        <span class="w-20 text-center text-muted fw-medium">Thành Tiền</span>
                        <span class="w-20 text-center text-muted fw-medium">Thao Tác</span>
                    </div>

                    <!-- Sản phẩm -->
                    @foreach ($cartItems as $item)
                        <div class="d-flex align-items-center p-3 border-bottom hover:bg-gray-100 transition">
                            <div class="w-10 text-center">
                                <input type="checkbox" name="selectedItems[]" value="{{ $item->id }}"
                                    class="form-check-input item-checkbox" onchange="updateCheckoutButton()">
                            </div>
                            <div class="w-10 text-center">
                                <img src="{{ asset($item->anh) }}" alt="{{ $item->ten_san_pham }}"
                                    class="w-20 h-20 object-cover rounded border" style="width: 80px; height: 80px;">
                            </div>
                            <div class="w-20 text-center text-accent fw-medium">
                                {{ number_format($item->gia, 0, ',', '.') }} VNĐ
                            </div>
                            <div class="w-20 text-center">
                                <form action="" method="POST"
                                    class="d-inline-flex align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="so_luong" value="{{ $item->pivot->so_luong }}"
                                        min="1" class="form-control w-50 text-center border-accent"
                                        onchange="updateTotal(this, {{ $item->id }}, {{ $item->gia }})">
                                    <button type="submit" class="ms-2 btn btn-link text-accent">Cập nhật</button>
                                </form>
                            </div>
                            <div class="w-20 text-center text-accent fw-medium" id="total-{{ $item->id }}">
                                {{ number_format($item->gia * $item->pivot->so_luong, 0, ',', '.') }} VNĐ
                            </div>
                            <div class="w-20 text-center">
                                <form action="{{ route('giohang.xoa', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger text-decoration-none"
                                        onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tổng cộng và nút hành động -->
                <div class="bg-white p-3 mt-4 rounded border shadow-sm d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <input type="checkbox" id="selectAllBottom" class="form-check-input me-2"
                            onchange="toggleSelectAll(this)">
                        <label for="selectAllBottom" class="text-muted">Chọn tất cả</label>
                        <button type="button" id="deleteSelected" class="btn btn-link text-danger"
                            onclick="deleteSelectedItems()">Xóa các mục chọn</button>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <p class="text-muted"><strong>Tổng số lượng:</strong> <span
                                id="tongSoLuong">{{ $tongSoLuong }}</span></p>
                        <p class="text-muted"><strong>Tổng giá:</strong> <span id="tongGia"
                                class="text-accent fw-medium">{{ number_format($tongGia, 0, ',', '.') }} VNĐ</span></p>
                        <button type="button" id="checkoutButton" class="btn btn-accent px-4 py-2" data-bs-toggle="modal"
                            data-bs-target="#datHangModal">Mua hàng</button>
                    </div>
                </div>
            </form>
        @endif

        <!-- Modal Đặt Hàng -->
        <div class="modal fade" id="datHangModal" tabindex="-1" aria-labelledby="datHangModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title fs-5 fw-bold text-dark" id="datHangModalLabel">Xác nhận đặt hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('don-hang.store') }}" method="POST" id="datHangForm">
                            @csrf
                            <!-- Thông tin người nhận -->
                            <div class="bg-white p-4 rounded border mb-4 shadow-sm">
                                <h6 class="fs-6 fw-bold text-dark mb-3">Thông tin người nhận</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="ten_nguoi_nhan" class="form-label text-muted">Tên người nhận</label>
                                        <input type="text" name="ten_nguoi_nhan" id="ten_nguoi_nhan"
                                            class="form-control border-accent @error('ten_nguoi_nhan') is-invalid @enderror"
                                            value="{{ old('ten_nguoi_nhan', Auth::user()->name) }}" required>
                                        @error('ten_nguoi_nhan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="so_dien_thoai" class="form-label text-muted">Số điện thoại</label>
                                        <input type="text" name="so_dien_thoai" id="so_dien_thoai"
                                            class="form-control border-accent @error('so_dien_thoai') is-invalid @enderror"
                                            value="{{ old('so_dien_thoai') }}" required>
                                        @error('so_dien_thoai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Địa chỉ nhận hàng -->
                            <div class="bg-white p-4 rounded border mb-4 shadow-sm">
                                <h6 class="fs-6 fw-bold text-dark mb-3">Địa chỉ nhận hàng</h6>
                                <div class="mb-3">
                                    <label for="dia_chi_id" class="form-label text-muted">Chọn địa chỉ</label>
                                    <select name="dia_chi_id" id="dia_chi_id"
                                        class="form-control border-accent @error('dia_chi_id') is-invalid @enderror"
                                        required>
                                        <option value="">Chọn địa chỉ</option>
                                        @foreach ($diaChis as $diaChi)
                                            <option value="{{ $diaChi->id }}"
                                                {{ old('dia_chi_id') == $diaChi->id ? 'selected' : '' }}>
                                                {{ $diaChi->dia_chi_chi_tiet }},
                                                {{ $diaChi->phuongXa->ten_phuong_xa ?? 'N/A' }},
                                                {{ $diaChi->quanHuyen->ten_quan_huyen ?? 'N/A' }},
                                                {{ $diaChi->thanhPho->ten_thanh_pho ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dia_chi_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phương thức thanh toán -->
                            <div class="bg-white p-4 rounded border mb-4 shadow-sm">
                                <h6 class="fs-6 fw-bold text-dark mb-3">Phương thức thanh toán</h6>
                                <div class="mb-3">
                                    <label class="form-check">
                                        <input type="radio" name="phuong_thuc_thanh_toan" value="cod" checked
                                            class="form-check-input">
                                        <span class="text-muted">Thanh toán khi nhận hàng (COD)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Tổng thanh toán -->
                            <div class="bg-white p-4 rounded border shadow-sm">
                                <h6 class="fs-6 fw-bold text-dark mb-3">Tổng thanh toán</h6>
                                <p class="text-muted mb-4"><strong>Tổng tiền:</strong> <span
                                        class="text-accent fw-medium">{{ number_format($tongGia, 0, ',', '.') }}
                                        VNĐ</span></p>
                                <button type="submit" class="btn btn-accent w-100 py-2 fw-medium">Xác nhận đặt
                                    hàng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const prices = {
            @foreach ($cartItems as $item)
                '{{ $item->id }}': {{ $item->gia }},
            @endforeach
        };

        function updateTotal(input, maSanPham, gia) {
            const soLuong = parseInt(input.value) || 0;
            const tong = gia * soLuong;
            document.getElementById('total-' + maSanPham).textContent = new Intl.NumberFormat('vi-VN').format(tong) +
            ' VNĐ';

            let tongSoLuong = 0,
                tongGia = 0;
            document.querySelectorAll('input[name="so_luong"]').forEach(input => {
                const soLuongItem = parseInt(input.value) || 0;
                const maSanPhamItem = input.closest('form').action.split('/').pop();
                const giaItem = prices[maSanPhamItem] || 0;
                tongSoLuong += soLuongItem;
                tongGia += giaItem * soLuongItem;
            });

            document.getElementById('tongSoLuong').textContent = tongSoLuong;
            document.getElementById('tongGia').textContent = new Intl.NumberFormat('vi-VN').format(tongGia) + ' VNĐ';
        }

        function toggleSelectAll(source) {
            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                checkbox.checked = source.checked;
            });
            updateCheckoutButton();
        }

        function updateCheckoutButton() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const checkoutButton = document.getElementById('checkoutButton');
            const modalCheckoutButton = document.querySelector('#datHangModal button[type="submit"]');
            const deleteButton = document.getElementById('deleteSelected');
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            checkoutButton.disabled = !anyChecked;
            if (modalCheckoutButton) modalCheckoutButton.disabled = !anyChecked;
            deleteButton.disabled = !anyChecked;
        }

        function updateModalForm() {
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            const selectedItems = Array.from(checkboxes).map(checkbox => checkbox.value);
            const form = document.getElementById('datHangForm');
            if (form) {
                const existingInputs = form.querySelectorAll('input[name="selectedItems[]"]');
                existingInputs.forEach(input => input.remove());
                selectedItems.forEach(item => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'selectedItems[]';
                    hiddenInput.value = item;
                    form.appendChild(hiddenInput);
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCheckoutButton();

            const modal = document.getElementById('datHangModal');
            if (modal) {
                modal.addEventListener('show.bs.modal', () => {
                    const selectAll = document.getElementById('selectAllBottom');
                    if (selectAll && !selectAll.checked) {
                        selectAll.click();
                        updateCheckoutButton();
                    }
                });
            }

            const form = document.getElementById('datHangForm');
            if (form) form.addEventListener('submit', updateModalForm);
        });
    </script>
@endsection
