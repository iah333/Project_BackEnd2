<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3 {{ session()->get('sidebar_collapsed', false) ? 'collapsed' : '' }}">
            <div class="user-info">
                <img src="{{ asset(auth()->user()->avatar ?? 'avatar/default.jpg') }}" class="user-avatar"
                    alt="avatar">
                <h6 class="text-white mb-0">{{ auth()->user()->name }}</h6>
            </div>
            <a href="#" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i
                    class="fas fa-tachometer-alt"></i><span> Dashboard</span></a>
            <a href="{{ route('admin.users.index') }}"
                class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i><span>
                    Quản lý người dùng</span></a>
            <a href="#"><i class="fas fa-file-alt"></i><span> Bài viết</span></a>
            <a href="{{ route('admin.donhang.index') }}"
                class="{{ request()->routeIs('admin.donhang.*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i><span> Đơn hàng</span>
            </a>
            <a href="{{ route('sanPham.index') }}" class="{{ request()->routeIs('sanPham.*') ? 'active' : '' }}"><i
                    class="fas fa-box"></i><span> Sản Phẩm</span></a>
            <a href="{{ route('danhMuc.index') }}" class="{{ request()->routeIs('danhMuc.*') ? 'active' : '' }}"><i
                    class="fas fa-list"></i><span> Danh Mục</span></a>
            <a href="#"><i class="fas fa-cog"></i><span> Cài đặt</span></a>
            <button class="btn btn-sm btn-outline-light toggle-sidebar w-100" onclick="toggleSidebar()">
                <i class="fas fa-angle-double-left"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="content flex-grow-1">
            <!-- Navbar -->
            <nav
                class="navbar navbar-light bg-light mb-4 rounded shadow-sm px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-bars menu-toggle" onclick="toggleMobileSidebar()"></i>
                    <span class="navbar-brand">Admin Control Panel</span>
                </div>
                <div class="user-dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2">{{ auth()->user()->name }}</span>
                        <img src="{{ asset(auth()->user()->avatar ?? 'avatar/default.jpg') }}" alt="avatar"
                            class="user-avatar">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.users.show', auth()->user()->id) }}"><i
                                    class="fas fa-user me-2"></i> Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Cài đặt</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="GET" action="{{ route('logout') }}" class="px-3">
                                @csrf
                                <button type="submit" class="btn btn-link logout-btn p-0"
                                    onclick="showLogoutConfirm(event)"><i class="fas fa-sign-out-alt me-2"></i> Đăng
                                    xuất</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS and SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle mobile sidebar
        function toggleMobileSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const menuToggle = document.querySelector('.menu-toggle');
            sidebar.classList.toggle('active');
            menuToggle.classList.toggle('active');
        }

        // Toggle sidebar collapse
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('collapsed');
            // Lưu trạng thái vào session
            fetch('/toggle-sidebar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    collapsed: sidebar.classList.contains('collapsed')
                })
            });
        }

        // SweetAlert2 for logout
        function showLogoutConfirm(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            Swal.fire({
                title: 'Đăng xuất',
                text: 'Bạn có chắc muốn đăng xuất khỏi hệ thống?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Đăng xuất',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
