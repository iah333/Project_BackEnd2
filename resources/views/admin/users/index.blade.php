@extends('layouts.admin')

@section('content')
    <!-- Thêm SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Thông báo -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    <div class="container-fluid">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-dark">Danh sách người dùng</h1>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-lg" onclick="showCreateConfirm(event)">
                    <i class="fas fa-plus me-2"></i>Thêm admin mới
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th scope="col">Tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->super_admin)
                                        <span class="badge bg-danger rounded-pill">Super Admin</span>
                                    @elseif ($user->is_admin)
                                        <span class="badge bg-primary rounded-pill">Admin</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">User</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-info btn-sm action-btn">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="decoration"><i
                                                    class="fas fa-eye"></i><span> Chi tiết</span></a>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm action-btn">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="decoration"> <i
                                                    class="fas fa-edit"></i><span> Sửa</span></a>
                                        </button>
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm action-btn delete-btn"
                                                data-id="{{ $user->id }}">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Không có người dùng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Script xử lý SweetAlert2 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn submit form ngay lập tức

                    const form = this.closest('form'); // Lấy form chứa nút bấm
                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa?',
                        text: 'Hành động này không thể hoàn tác!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Chỉ submit nếu người dùng xác nhận
                        }
                    });
                });
            });
        });
    </script>
@endsection
