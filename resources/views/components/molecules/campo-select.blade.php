@props(['name', 'label'])

<div class="mb-4">
    <x-atoms.label for="{{ $name }}">{{ $label }}</x-atoms.label>

    <x-atoms.select name="{{ $name }}" id="{{ $name }}">
        {{ $slot }}
    </x-atoms.select>

    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>