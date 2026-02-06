@props([
    'variant' => 'dark',
])

@php
    $isLight = $variant === 'light';
    $containerClasses = $isLight
        ? 'border-t border-stone-200/70 bg-stone-50 text-stone-800'
        : 'border-t border-stone-200/70 bg-stone-900 text-stone-100';
    $logo = $isLight ? asset('/src/brand/logo_green.svg') : asset('/src/brand/logo_white.svg');
    $linkClasses = $isLight
        ? 'text-stone-600 transition hover:text-stone-900'
        : 'text-stone-200 transition hover:text-stone-50';
    $mutedClasses = $isLight ? 'text-stone-500' : 'text-stone-400';
@endphp

<footer class="{{ $containerClasses }}">
    <div class="mx-auto flex w-full max-w-6xl flex-col items-center justify-between gap-6 px-4 py-10 md:flex-row">
        <div class="flex items-center gap-3">
            <img src="{{ $logo }}" alt="Logo" class="h-10">
        </div>

        <nav class="flex items-center gap-6 text-sm font-medium">
            <a href="{{ route('home') }}" class="{{ $linkClasses }}">Home</a>
            <a href="{{ route('catalog') }}" class="{{ $linkClasses }}">Catalogo</a>
        </nav>

        <p class="text-sm {{ $mutedClasses }}">&copy; {{ date('Y') }} Kode Perfumaria. Todos os direitos reservados.</p>
    </div>
</footer>
