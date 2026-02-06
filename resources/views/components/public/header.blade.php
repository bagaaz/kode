<header class="sticky top-0 z-40 border-b border-stone-200/70 bg-stone-50/90 backdrop-blur">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4">
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('/src/brand/logo_green.svg') }}" alt="Logo" class="h-10">
        </a>

        <nav class="hidden items-center gap-6 text-sm font-medium md:flex">
            <a
                href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'text-stone-900' : 'text-stone-500' }} text-sm font-medium transition-colors duration-200 ease-out hover:text-stone-900"
            >
                Home
            </a>
            <a
                href="{{ route('catalog') }}"
                class="{{ request()->routeIs('catalog') ? 'text-stone-900' : 'text-stone-500' }} text-sm font-medium transition-colors duration-200 ease-out hover:text-stone-900"
            >
                Catalogo
            </a>
        </nav>

        <x-ui.button
            href="{{ route('catalog') }}"
            variant="ghost"
            icon="lucide-arrow-right"
            icon-class="h-4 w-4"
        >
            Ver Catalogo
        </x-ui.button>
    </div>
</header>
