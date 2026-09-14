@props(['name', 'label', 'type' => 'text', 'value' => null])

<div class="mb-4">
    <x-atoms.label for="{{ $name }}">{{ $label }}</x-atoms.label>

    <x-atoms.input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
    />

    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>