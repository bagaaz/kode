@props([
    'type' => 'success',
    'message' => null,
])

@php
    $styles = match ($type) {
        'error' => 'border-red-200 bg-red-50 text-red-800',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-800',
        default => 'border-green/20 bg-green/10 text-green',
    };
@endphp

<div {{ $attributes->merge(['class' => "rounded-sm border p-4 text-sm {$styles}"]) }}>
    {{ $message ?? $slot }}
</div>
