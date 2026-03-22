<header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 border-b border-stone-200/70 bg-white/95 backdrop-blur-md">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4">
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('/src/brand/logo_green.svg') }}" alt="Kode Perfumaria" class="h-9">
        </a>

        <nav class="hidden items-center gap-8 md:flex">
            <a
                href="{{ route('home') }}"
                class="relative pb-0.5 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-stone-900' : 'text-stone-500 hover:text-stone-900' }}"
            >
                Home
                @if (request()->routeIs('home'))
                    <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 rounded-full bg-gold"></span>
                @endif
            </a>
            <a
                href="{{ route('catalog') }}"
                class="relative pb-0.5 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('catalog') ? 'text-stone-900' : 'text-stone-500 hover:text-stone-900' }}"
            >
                Catálogo
                @if (request()->routeIs('catalog'))
                    <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 rounded-full bg-gold"></span>
                @endif
            </a>
        </nav>

        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('catalog') }}" variant="primary" size="sm" icon="lucide-arrow-right">
                Ver Catálogo
            </x-ui.button>

            <button
                @click="mobileOpen = !mobileOpen"
                class="flex h-9 w-9 items-center justify-center rounded-sm text-stone-600 transition hover:bg-stone-100 md:hidden"
                aria-label="Menu"
            >
                <x-lucide-menu x-show="!mobileOpen" class="h-5 w-5" />
                <x-lucide-x x-show="mobileOpen" class="h-5 w-5" style="display:none" />
            </button>
        </div>
    </div>

    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="border-t border-stone-200/70 bg-white px-4 pb-4 md:hidden"
        style="display:none"
    >
        <nav class="flex flex-col gap-1 pt-3">
            <a
                href="{{ route('home') }}"
                class="rounded-sm px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('home') ? 'bg-green/5 text-green' : 'text-stone-700 hover:bg-stone-100 hover:text-stone-900' }}"
            >
                Home
            </a>
            <a
                href="{{ route('catalog') }}"
                class="rounded-sm px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('catalog') ? 'bg-green/5 text-green' : 'text-stone-700 hover:bg-stone-100 hover:text-stone-900' }}"
            >
                Catálogo
            </a>
        </nav>
    </div>
</header>
