<footer class="border-t border-stone-200/70 bg-stone-900 text-stone-100">
    <div class="mx-auto flex w-full max-w-6xl flex-col items-center justify-between gap-6 px-4 py-10 md:flex-row">
        <div class="flex items-center gap-3">
            <img src="{{ asset('/src/brand/logo_white.svg') }}" alt="Logo" class="h-10">
        </div>

        <nav class="flex items-center gap-6 text-sm font-medium">
            <a href="{{ route('home') }}" class="text-stone-200 transition hover:text-stone-50">Home</a>
            <a href="{{ route('catalog') }}" class="text-stone-200 transition hover:text-stone-50">Catalogo</a>
        </nav>

        <p class="text-sm text-stone-400">&copy; {{ date('Y') }} Kode Perfumaria. Todos os direitos reservados.</p>
    </div>
</footer>
