<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "Admin") - Dispensario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Dispensario Admin</span>
            <div>
                <a href="/" class="btn btn-sm btn-outline-light me-2">Cliente</a>
                <a href="/admin/logout-now" class="btn btn-sm btn-outline-light">Salir</a>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid mt-4">
        @if(session("success"))
            <div class="alert alert-success">{{ session("success") }}</div>
        @endif
        @yield("content")
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
