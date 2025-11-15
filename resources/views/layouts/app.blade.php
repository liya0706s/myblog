<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel')</title>
    {{-- Bootstrap CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
        <div class="container">
            <a href="{{ url('/') }}" class="navbar-brand">My Blog</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a href="" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="" class="nav-link">Register</a></li>
                    @else
                        <li class="nav-item"><a href="#" class="nav-link">{{ Auth::user()->name }}</a></li>
                        <li class="nav-item">
                            <form action="">
                                @csrf
                                <button class="btn btn-link" type="submit">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="container">
        @yield('content')
    </div>
    @yield('scripts')

    {{-- Bootstrap JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>