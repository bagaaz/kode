@props([
    'href' => null,
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'right',
    'iconClass' => 'h-4 w-4',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-sm font-medium transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-stone-400/70 disabled:opacity-50 disabled:pointer-events-none';
    $variants = [
        'primary' => 'bg-green text-stone-50 hover:bg-green-hover',
        'secondary' => 'bg-gold text-stone-900 hover:bg-gold-hover',
        'outline' => 'border border-green text-green hover:bg-green/10',
        'ghost' => 'text-stone-700 hover:text-stone-900 hover:bg-stone-100',
    ];
    $sizes = [
        'sm' => 'h-9 px-4 text-sm',
        'md' => 'h-11 px-6 text-sm',
        'lg' => 'h-12 px-7 text-base',
    ];

    $variantClasses = $variants[$variant] ?? $variants['primary'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $classes = $base.' '.$variantClasses.' '.$sizeClasses;
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->except('type')->merge(['class' => $classes]) }}>
        @if ($icon && $iconPosition === 'left')
            <x-dynamic-component :component="$icon" class="{{ $iconClass }}" />
        @endif
        {{ $slot }}
        @if ($icon && $iconPosition === 'right')
            <x-dynamic-component :component="$icon" class="{{ $iconClass }}" />
        @endif
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        @if ($icon && $iconPosition === 'left')
            <x-dynamic-component :component="$icon" class="{{ $iconClass }}" />
        @endif
        {{ $slot }}
        @if ($icon && $iconPosition === 'right')
            <x-dynamic-component :component="$icon" class="{{ $iconClass }}" />
        @endif
    </button>
@endif
