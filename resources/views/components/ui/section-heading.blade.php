@props([
    'label' => null,
    'align' => 'left',
    'size'  => 'md',
])

@php
    $alignClass = $align === 'center' ? 'text-center items-center' : 'items-start';
    $sizes = [
        'sm' => 'text-2xl md:text-3xl',
        'md' => 'text-3xl md:text-4xl',
        'lg' => 'text-4xl md:text-5xl',
    ];
    $titleSize = $sizes[$size] ?? $sizes['md'];
@endphp

<div class="flex flex-col gap-2 {{ $alignClass }}">
    @if ($label)
        <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gold">
            <span class="h-px w-5 rounded-full bg-gold"></span>
            {{ $label }}
            <span class="h-px w-5 rounded-full bg-gold"></span>
        </span>
    @endif
    <h2 class="{{ $titleSize }} font-bold leading-tight text-stone-900">
        {{ $slot }}
    </h2>
</div>
