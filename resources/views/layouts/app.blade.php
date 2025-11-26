<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard IoT Asrama')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">IoT Asrama</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('riwayat') }}">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kontak.index') }}">Kontak</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kamera.index') }}">Kamera</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('distribusi') }}">Distribusi</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container mt-4">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
