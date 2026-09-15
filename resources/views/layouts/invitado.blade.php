<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'VentasFix')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">

    @if (session('exito'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded w-full max-w-sm">
            {{ session('exito') }}
        </div>
    @endif

    @yield('contenido')
</body>
</html>