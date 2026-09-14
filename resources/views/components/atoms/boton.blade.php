@props(['tipo' => 'button', 'variante' => 'primario'])

@php
    $clases = match ($variante) {
        'peligro' => 'bg-red-600 hover:bg-red-700',
        'secundario' => 'bg-gray-500 hover:bg-gray-600',
        default => 'bg-blue-600 hover:bg-blue-700',
    };
@endphp

<button type="{{ $tipo }}" {{ $attributes->merge(['class' => "px-4 py-2 rounded text-white text-sm $clases"]) }}>
    {{ $slot }}
</button>