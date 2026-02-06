@props(['variant' => 'soft'])

@php
    $variants = [
        'soft' => 'bg-stone-100 text-stone-700',
        'solid' => 'bg-stone-900 text-stone-50',
        'gold' => 'bg-amber-300 text-stone-900',
        'green' => 'bg-green text-stone-50'
    ];

    $classes = $variants[$variant] ?? $variants['soft'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-3 py-1 text-xs font-medium '.$classes]) }}>
    {{ $slot }}
</span>
