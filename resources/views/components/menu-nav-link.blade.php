@props(['active'])

@php
    $classes = $active ? 'bg-blue-600 text-white font-medium hover:bg-blue-700' : 'text-gray-600 hover:bg-gray-100';
@endphp

<a
    {{ $attributes->merge([
        'class' => $classes . ' flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-300',
    ]) }}>
    {{ $slot }}
</a>
