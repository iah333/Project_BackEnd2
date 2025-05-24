<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Thêm Font Awesome -->
    <title>@yield('title', 'PhoneStore')</title>
    <style>
        .navbar-custom {
            background-color: #515154;
        }

        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.6);
            transition: color 0.3s ease;
        }

        .navbar-custom .nav-link:hover {
            color: rgba(255, 255, 255, 1);
        }

        .navbar-brand img {
            height: 40px;
        }

        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }

        /* Style cho dropdown user */
        .dropdown-menu {
            background-color: #515154;
        }

        .dropdown-item {
            color: rgba(255, 255, 255, 0.6);
        }

        .dropdown-item:hover {
            color: rgba(255, 255, 255, 1);
            background-color: #3c3c3f;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
        }

        .user-name {
            color: rgba(255, 255, 255, 0.6);
            margin-left: 8px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PhoneStore">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    @if (isset($danhMucs) && is_countable($danhMucs))
                        @foreach ($danhMucs as $danhMuc)
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('danh-muc.slug', $danhMuc->ten_danh_muc) }}">{{ $danhMuc->ten_danh_muc }}</a>
                            </li>
                        @endforeach
                    @else
                        <li class="nav-item">
                            <span class="nav-link">Không có danh mục</span>
                        </li>
                    @endif
                </ul>
                <!-- Dịch icon sang trái bằng cách thêm margin phải -->
                <div class="dropdown ms-5 me-1 d-flex align-items-center">
                    @auth
                        <img src="{{ asset('avatar/' . (auth()->user()->avatar ?? 'default.jpg')) }}" class="user-avatar"
                            alt="avatar">
                        <span class="user-name">{{ auth()->user()->name }}!</span>
                    @else
                        <i class="fas fa-user" style="font-size: 24px; color: rgba(255, 255, 255, 0.6);"></i>
                    @endauth
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" style="margin-left: 5px;"></a>

                    <ul class="dropdown-menu">
                        @guest
                            <li><a class="dropdown-item" href="{{ route('login') }}">Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Đăng ký</a></li>
                        @endguest
                        @auth
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng
                                    xuất</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                            <li><a class="dropdown-item" href="{{ route('users.profile') }}">Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="{{ route('gioHang.index') }}">Giỏ Hàng</a></li>
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
