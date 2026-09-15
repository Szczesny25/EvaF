{{--
    Organismo: sidebar
    Navegación lateral básica. Para agregar más secciones, copia un <a> más.
--}}
<aside class="w-56 bg-gray-900 text-white min-h-screen p-4">
    <h2 class="text-lg font-bold mb-6">VentasFix</h2>

    <nav class="space-y-2">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('usuarios.index') }}"
           class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('usuarios.*') ? 'bg-gray-700' : '' }}">
            Usuarios
        </a>
        <a href="{{ route('productos.index') }}"
           class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('productos.*') ? 'bg-gray-700' : '' }}">
            Productos
        </a>
        <a href="{{ route('clientes.index') }}"
           class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('clientes.*') ? 'bg-gray-700' : '' }}">
            Clientes
        </a>

        <form method="POST" action="{{ route('logout') }}" class="pt-4">
            @csrf
            <button type="submit" class="block w-full text-left px-3 py-2 rounded hover:bg-gray-700 text-red-300">
                Cerrar sesión
            </button>
        </form>
    </nav>
</aside>