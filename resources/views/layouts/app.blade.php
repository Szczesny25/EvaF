<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'VentasFix') - Backoffice</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <div class="flex">
        <x-organisms.sidebar />

        <main class="flex-1 p-6">
            @if (session('exitos compa'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
                    {{ session('exitos compa') }}
                </div>
            @endif

            @if (session('mal ahi'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                    {{ session('mal ahi') }}
                </div>
            @endif

            @yield('contenido')
        </main>
    </div>

</body>
</html>