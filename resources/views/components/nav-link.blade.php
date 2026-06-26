@props(['active'])

@php
// Kita ganti styling-nya agar tidak ada border-b-2 (garis bawah) 
// dan warnanya disesuaikan untuk background gelap
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 text-sm font-bold leading-5 text-white transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-400 hover:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>