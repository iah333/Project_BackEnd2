<!DOCTYPE html>
<html>

<head>
    <title>Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/scripts.js') }}"></script>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="{{ '/' }}">Laravel Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ 'login' }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ 'register' }}">Create user</a>
                    </li>
                    @else
                    <form method="get" action="{{ route('signout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="display: inline; padding: 0; border: none; background: none;">
                            Logout
                        </button>
                    </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</body>

</html>