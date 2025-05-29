<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/register.css') }}">
    <title>@yield('title', 'PhoneStore')</title>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            width: 100%;
        }

        .navbar-custom {
            background-color: #2c2c2e;
            /* Màu nền tối hơn, sang trọng */
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Hiệu ứng bóng */
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-custom .navbar-brand img {
            height: 55px;
            
            transition: transform 0.3s ease;
            margin-left: 70px;
            /* đẩy logo sang phải */
        }

        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .navbar-custom .nav-link:hover {
            color: #ffffff;
            background-color: #3a3a3c;
        }

        .navbar-custom .navbar-toggler {
            border: none;
            color: rgba(255, 255, 255, 0.7);
        }

        .navbar-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.7)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Search Form */
        .search-form {
            max-width: 300px;
            position: relative;
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

        /* Dropdown */
        .navbar-custom .dropdown-menu {
            background-color: #2c2c2e;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            min-width: 200px;
        }

        .navbar-custom .dropdown-item {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .navbar-custom .dropdown-item i {
            margin-right: 10px;
            font-size: 1rem;
        }

        .navbar-custom .dropdown-item:hover {
            color: #ffffff;
            background-color: #3a3a3c;
        }

        /* User Avatar */
        .user-avatar {
            width: 35px;
            height: 35px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.1);
        }

        .user-name {
            color: rgba(255, 255, 255, 0.7);
            margin-left: 10px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .user-name:hover {
            color: #ffffff;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .navbar-custom .navbar-nav {
                background-color: #2c2c2e;
                padding: 15px;
                border-radius: 5px;
                margin-top: 10px;
            }

            .navbar-custom .nav-link {
                padding: 10px;
                margin: 5px 0;
            }

            .search-form {
                max-width: 100%;
                margin: 10px 0;
            }

            .navbar-custom .dropdown-menu {
                right: auto;
                left: 0;
                width: 100%;
            }

            .dropdown.ms-5 {
                margin-left: 0 !important;
            }
        }

        /* Footer */
        footer {
            background-color: #1a1a1c;
            color: #ffffff;
            padding: 40px 0;
        }

        footer h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        footer p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 10px;
        }

        footer .text-md-end {
            text-align: right;
        }

        @media (max-width: 768px) {
            footer .text-md-end {
                text-align: left;
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <a class="navbar-brand ms-3" href="/">
                <img src="{{ asset('img/logo.png') }}" alt="Logo PhoneStore">
                </a>
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
                <form class="search-form d-flex me-3" action="{{ route('san-pham.search') }}" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm sản phẩm..."
                        aria-label="Search">
                    <button class="btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="dropdown ms-5 d-flex align-items-center">
                    @auth
                        <img src="{{ asset(auth()->user()->avatar) }}" alt="Avatar" class="rounded-circle"
                            style="width: 40px; height: 40px;"></p>
                        <span class="user-name">{{ auth()->user()->name }}</span>
                    @else
                        <i class="fas fa-user" style="font-size: 24px; color: rgba(255, 255, 255, 0.6);"></i>
                    @endauth
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" style="margin-left: 5px;"></a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @guest
                            <li><a class="dropdown-item" href="{{ route('login.form') }}"><i class="fas fa-sign-in-alt"></i>
                                    Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="{{ route('register.form') }}"><i
                                        class="fas fa-user-plus"></i> Đăng ký</a></li>
                        @endguest
                        @auth
                            <li><a class="dropdown-item" href="{{ route('don-hang.index') }}"><i
                                        class="fas fa-user-circle"></i>Thông tin đơn hàng</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.profile') }}"><i
                                        class="fas fa-user-circle"></i> Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="{{ route('giohang.index') }}"><i
                                        class="fas fa-shopping-cart"></i> Giỏ Hàng</a></li>

                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Công ty TNHH Hai Thằng Bạn</h5>
                    <p>Địa chỉ: 123 Đường Láng, Quận Đống Đa, Hà Nội</p>
                    <p>Email: <a href="mailto:contact@haithangban.com"
                            class="text-white text-decoration-none">contact@haithangban.com</a></p>
                    <p>Hotline: <a href="tel:0123456789" class="text-white text-decoration-none">0123 456 789</a></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Về chúng tôi</h5>
                    <p>Được thành lập bởi hai người bạn thân, chúng tôi mang đến những sản phẩm công nghệ chất lượng với
                        giá cả hợp lý.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Load Bootstrap JS trước nội dung -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>