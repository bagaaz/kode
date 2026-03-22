@props([
    'type'    => 'success',
    'message' => null,
])

@php
    $styles = match ($type) {
        'error'   => 'border-red-200 bg-red-50 text-red-800',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-800',
        default   => 'border-green/20 bg-green/10 text-green',
    };

    $icon = match ($type) {
        'error'   => 'lucide-alert-circle',
        'warning' => 'lucide-triangle-alert',
        default   => 'lucide-circle-check',
    };
@endphp

<div {{ $attributes->merge(['class' => "flex items-start gap-3 rounded-sm border p-4 text-sm {$styles}"]) }}>
    <x-dynamic-component :component="$icon" class="mt-0.5 h-4 w-4 shrink-0" />
    <div>{{ $message ?? $slot }}</div>
</div>
