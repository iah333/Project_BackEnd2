<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="public/css/admin/register">
    <title>@yield('title', 'PhoneStore')</title>
    <style>
        /* Giữ nguyên màu sắc và cải thiện giao diện */
        .navbar-custom {
            background-color: #515154;
            padding: 10px 0;
            position: relative;
            z-index: 1000;
            /* Đảm bảo navbar nằm trên các phần tử khác */
        }

        .navbar-custom .navbar-brand img {
            height: 40px;
        }

        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
            padding: 10px 15px;
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .navbar-custom .nav-link:hover {
            color: rgba(255, 255, 255, 1);
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        /* Toggler icon trên mobile */
        .navbar-custom .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.6);
        }

        .navbar-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.6)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Dropdown user - Cải thiện vị trí và tránh tràn ra ngoài */
        .navbar-custom .dropdown-menu {
            background-color: #515154;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            min-width: 180px;
            /* Đảm bảo dropdown đủ rộng */
            right: 0;
            /* Đặt dropdown bên phải */
            left: auto;
            /* Loại bỏ căn trái mặc định */
        }

        .navbar-custom .dropdown-item {
            color: rgba(255, 255, 255, 0.6);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-custom .dropdown-item i {
            margin-right: 8px;
        }

        .navbar-custom .dropdown-item:hover {
            color: rgba(255, 255, 255, 1);
            background-color: #3c3c3f;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .user-name {
            color: rgba(255, 255, 255, 0.6);
            margin-left: 8px;
            font-weight: 500;
        }

        /* Search form */
        .search-form {
            max-width: 200px;
        }

        .search-form .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
            font-size: 0.875rem;
        }

        .search-form .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .search-form .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: none;
            color: #fff;
        }

        .search-form .btn {
            background-color: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.6);
        }

        .search-form .btn:hover {
            color: rgba(255, 255, 255, 1);
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .navbar-custom .navbar-nav {
                background-color: #515154;
                padding: 10px;
                border-radius: 5px;
            }

            .navbar-custom .nav-link {
                padding: 10px;
            }

            .search-form {
                max-width: 100%;
                margin: 10px 0;
            }

            .navbar-custom .dropdown-menu {
                right: auto;
                /* Đặt lại vị trí trên mobile */
                left: 0;
                width: 100%;
            }

            .dropdown.ms-5 {
                margin-left: 0 !important;
            }
        }

        /* Đảm bảo dropdown không tràn ra ngoài màn hình */
        .dropdown-menu[data-bs-popper] {
            margin-top: 0;
            transform: none !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PhoneStore">
            </a>

            <!-- Toggler Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu Categories -->
                <ul class="navbar-nav mx-auto">
                    @if (isset($danhMucs) && is_countable($danhMucs))
                        @foreach ($danhMucs as $danhMuc)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('danh-muc.slug', $danhMuc->ten_danh_muc) }}">
                                    {{ $danhMuc->ten_danh_muc }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li class="nav-item">
                            <span class="nav-link">Không có danh mục</span>
                        </li>
                    @endif
                </ul>

                <!-- Search Form -->
                <form class="search-form d-flex me-3" action="{{ route('sanPham.index') }}" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm sản phẩm..."
                        aria-label="Search">
                    <button class="btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <!-- User Dropdown -->
                <div class="dropdown ms-5 d-flex align-items-center">
                    @auth
                        <img src="{{ asset('avatar/' . (auth()->user()->avatar ?? 'default.jpg')) }}" class="user-avatar"
                            alt="avatar">
                        <span class="user-name">{{ auth()->user()->name }}!</span>
                    @else
                        <i class="fas fa-user" style="font-size: 24px; color: rgba(255, 255, 255, 0.6);"></i>
                    @endauth
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" style="margin-left: 5px;"></a>

                    <ul class="dropdown-menu dropdown-menu-end"> <!-- Sử dụng dropdown-menu-end -->
                        @guest
                            <li>
                                <a class="dropdown-item" href="{{ route('login.form') }}">
                                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('register.form') }}">
                                    <i class="fas fa-user-plus"></i> Đăng ký
                                </a>
                            </li>
                        @endguest
                        @auth
                            <li>
                                <a class="dropdown-item" href="{{ route('users.profile') }}">
                                    <i class="fas fa-user-circle"></i> Hồ sơ
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('gioHang.index') }}">
                                    <i class="fas fa-shopping-cart"></i> Giỏ Hàng
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="GET"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Công ty TNHH Hai Thằng Bạn</h5>
                    <p>Địa chỉ: 123 Đường Láng, Quận Đống Đa, Hà Nội</p>
                    <p>Email: contact@haithangban.com</p>
                    <p>Hotline: 0123 456 789</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Về chúng tôi</h5>
                    <p>Được thành lập bởi hai người bạn thân, chúng tôi mang đến những sản phẩm công nghệ chất lượng với
                        giá cả hợp lý.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
