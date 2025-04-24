<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PhoneStore">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    @if (isset($danhMucs) && is_countable($danhMucs))
                        @foreach ($danhMucs as $danhMuc)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('danh-muc.slug', $danhMuc->ten_danh_muc) }}">{{ $danhMuc->ten_danh_muc }}</a>
                            </li>
                        @endforeach
                    @else
                        <li class="nav-item">
                            <span class="nav-link">Không có danh mục</span>
                        </li>
                    @endif
                </ul>
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
                    <p>Được thành lập bởi hai người bạn thân, chúng tôi mang đến những sản phẩm công nghệ chất lượng với giá cả hợp lý.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>