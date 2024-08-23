@props(['value', 'icon' => null])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif
    {{ $value ?? $slot }}
</label>
