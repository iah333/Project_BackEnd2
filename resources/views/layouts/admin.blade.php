<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
        }

        .sidebar a {
            color: #ffffff;
            padding: 15px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            padding: 20px;
        }

        .card {
            border-radius: 12px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <div class="d-flex align-items-center mb-4">
                <img src="{{ asset('uploads/' . (auth()->user()->picture ?? 'default.jpg')) }}" class="user-avatar me-2" alt="Avatar">
                <h6 class="text-white mb-0">{{ auth()->user()->name }}</h6>
            </div>
            <a href="#">Dashboard</a>
            <a href=" {{ Route('listUser') }}">Quản lý người dùng</a>
            <a href="#">Bài viết</a>
            <a href="{{ route('sanPham.index') }}">Sản Phẩm</a>
            <a href="{{ route('danhMuc.index') }}">Danh Mục</a>
            <a href="#">Cài đặt</a>
        </div>

        <!-- Content -->
        <div class="content flex-grow-1">
            <!-- Navbar with user dropdown -->
            <nav class="navbar navbar-light bg-light mb-4 rounded shadow-sm px-4 d-flex justify-content-between align-items-center">
                <span class="navbar-brand">Admin Panel</span>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2">{{ auth()->user()->name }}</span>
                        <img src="{{ asset('uploads/' . (auth()->user()->picture ?? 'default.jpg')) }}" alt="Avatar" class="user-avatar">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ Route('detailsUser') }}">Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="get" action="{{ route('signout') }}" class="px-3">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger p-0">Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
