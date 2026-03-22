@props([
    'label'   => '',
    'value'   => '0',
    'icon'    => null,
    'variant' => 'default',
])

@php
    $variants = [
        'default' => [
            'icon_bg'    => 'bg-stone-100',
            'icon_text'  => 'text-stone-400',
            'value_text' => 'text-stone-900',
        ],
        'green' => [
            'icon_bg'    => 'bg-green/10',
            'icon_text'  => 'text-green',
            'value_text' => 'text-green',
        ],
        'gold' => [
            'icon_bg'    => 'bg-gold/10',
            'icon_text'  => 'text-gold',
            'value_text' => 'text-stone-900',
        ],
        'red' => [
            'icon_bg'    => 'bg-red-50',
            'icon_text'  => 'text-red-500',
            'value_text' => 'text-red-600',
        ],
    ];
    $v = $variants[$variant] ?? $variants['default'];
@endphp

<article class="rounded-md border border-stone-200 bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <p class="text-xs font-medium uppercase tracking-wide text-stone-500">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold tracking-tight {{ $v['value_text'] }}">{{ $value }}</p>
        </div>

        @if ($icon)
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $v['icon_bg'] }}">
                <x-dynamic-component :component="$icon" class="h-5 w-5 {{ $v['icon_text'] }}" />
            </div>
        @endif
    </div>
</article>
