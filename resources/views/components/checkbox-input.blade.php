@props(['id', 'name', 'value' => '', 'checked' => false])

<div class="flex items-center">
    <input
        type="checkbox"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'form-checkbox h-4 w-4 text-black transition duration-150 ease-in-out']) }}
    >

    <label for="{{ $id }}" class="ml-2 block text-sm leading-5 text-gray-700 dark:text-gray-300">
        {{ $slot }}
    </label>
</div>
