@props([
    'variant' => 'dark',
])

@php
    $isDark = $variant === 'dark';
    $bg           = $isDark ? 'bg-stone-900' : 'bg-white';
    $borderTop    = $isDark ? 'border-stone-800' : 'border-stone-200/70';
    $borderInner  = $isDark ? 'border-stone-800' : 'border-stone-200';
    $logo         = $isDark ? asset('/src/brand/logo_white.svg') : asset('/src/brand/logo_green.svg');
    $textMuted    = $isDark ? 'text-stone-500' : 'text-stone-400';
    $textBody     = $isDark ? 'text-stone-400' : 'text-stone-500';
    $textHeading  = $isDark ? 'text-stone-200' : 'text-stone-700';
    $linkClass    = $isDark ? 'text-stone-400 hover:text-stone-100 transition-colors' : 'text-stone-500 hover:text-stone-900 transition-colors';
@endphp

<footer class="{{ $bg }} border-t {{ $borderTop }}">
    <div class="mx-auto w-full max-w-6xl px-4 py-14">
        <div class="grid gap-10 md:grid-cols-[2fr_1fr_1fr]">

            {{-- Brand column --}}
            <div class="max-w-xs space-y-5">
                <img src="{{ $logo }}" alt="Kode Perfumaria" class="h-9">
                <p class="text-sm leading-relaxed {{ $textBody }}">
                    Fragrâncias exclusivas, numeradas e artesanais — desenvolvidas para quem acredita que o perfume é a memória mais duradoura.
                </p>
                <div class="flex items-center gap-1.5">
                    <span class="h-0.5 w-8 rounded-full bg-gold"></span>
                    <span class="h-0.5 w-4 rounded-full bg-gold/40"></span>
                    <span class="h-0.5 w-2 rounded-full bg-gold/20"></span>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="space-y-4">
                <h3 class="text-xs font-semibold uppercase tracking-widest {{ $textHeading }}">Navegação</h3>
                <nav class="flex flex-col gap-3">
                    <a href="{{ route('home') }}" class="text-sm {{ $linkClass }}">Home</a>
                    <a href="{{ route('catalog') }}" class="text-sm {{ $linkClass }}">Catálogo</a>
                </nav>
            </div>

            {{-- Contact --}}
            <div class="space-y-4">
                <h3 class="text-xs font-semibold uppercase tracking-widest {{ $textHeading }}">Contato</h3>
                <div class="flex flex-col gap-3 text-sm {{ $textBody }}">
                    <span>contato@kodeperfumaria.com.br</span>
                    <span>@kodeperfumaria</span>
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t {{ $borderInner }} pt-6 md:flex-row">
            <p class="text-xs {{ $textMuted }}">&copy; {{ date('Y') }} Kode Perfumaria. Todos os direitos reservados.</p>
            <p class="text-xs {{ $textMuted }}">Feito com cuidado.</p>
        </div>
    </div>
</footer>
