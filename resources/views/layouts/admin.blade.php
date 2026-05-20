<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Carpintería Ro-Ca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-dark vh-100 p-3">
                <h5 class="text-white">Carpintería Ro-Ca</h5>
                <hr class="text-white">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('pedidos.index') }}">📦 Pedidos</a>
                    </li>
                </ul>
            </nav>

            <main class="col-md-10 ms-sm-auto px-md-4">
                @if(session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>