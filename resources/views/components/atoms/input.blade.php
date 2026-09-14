@props(['type' => 'text'])

<input
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500']) }}
>