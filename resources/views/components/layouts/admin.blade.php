@props([
    'title' => 'Painel Administrativo',
])

<x-layouts.public :title="$title">
    <div class="min-h-screen md:grid md:grid-cols-[260px_minmax(0,1fr)]">

        {{-- Sidebar --}}
        <aside class="flex flex-col border-b border-green/30 bg-green text-stone-50 md:min-h-screen md:border-b-0 md:border-r">

            {{-- Logo --}}
            <div class="px-5 py-5">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center">
                    <img src="{{ asset('/src/brand/logo_white.svg') }}" alt="Kode Perfumaria" class="h-9 w-auto" />
                </a>
            </div>

            <div class="mx-4 border-t border-white/10"></div>

            {{-- Navigation --}}
            @php
                $navItems = [
                    [
                        'route' => 'admin.dashboard',
                        'match' => 'admin.dashboard',
                        'label' => 'Dashboard',
                        'icon'  => 'lucide-layout-dashboard',
                    ],
                    [
                        'route' => 'admin.users.index',
                        'match' => 'admin.users.*',
                        'label' => 'Usuários',
                        'icon'  => 'lucide-users',
                    ],
                    [
                        'route' => 'admin.perfumes.index',
                        'match' => 'admin.perfumes.*',
                        'label' => 'Perfumes',
                        'icon'  => 'lucide-flask-conical',
                    ],
                ];
            @endphp

            @php
                $catalogActive = request()->routeIs('admin.catalog-settings.*');
                $catalogTypes = [
                    ['type' => 'families',       'label' => 'Famílias olfativas'],
                    ['type' => 'concentrations', 'label' => 'Concentrações'],
                    ['type' => 'occasions',      'label' => 'Ocasiões'],
                    ['type' => 'intensities',    'label' => 'Intensidades'],
                    ['type' => 'tags',           'label' => 'Tags'],
                    ['type' => 'collections',    'label' => 'Coleções'],
                    ['type' => 'notes',          'label' => 'Notas olfativas'],
                ];
            @endphp

            <nav class="flex flex-1 flex-col gap-0.5 px-3 py-4">
                @foreach ($navItems as $item)
                    @php $active = request()->routeIs($item['match']); @endphp
                    <a
                        href="{{ route($item['route']) }}"
                        class="group flex items-center gap-3 rounded-sm px-3 py-2.5 text-sm font-medium transition-colors duration-150 {{ $active ? 'bg-white/15 text-white' : 'text-stone-300 hover:bg-white/8 hover:text-white' }}"
                    >
                        <x-dynamic-component :component="$item['icon']" class="h-4 w-4 shrink-0 {{ $active ? 'text-gold' : 'text-stone-400 group-hover:text-stone-200' }}" />
                        {{ $item['label'] }}
                        @if ($active)
                            <span class="ml-auto h-1.5 w-1.5 rounded-full bg-gold"></span>
                        @endif
                    </a>
                @endforeach

                {{-- Catálogo submenu --}}
                <div x-data="{ open: {{ $catalogActive ? 'true' : 'false' }} }">
                    <button
                        type="button"
                        @click="open = !open"
                        class="group flex w-full items-center gap-3 rounded-sm px-3 py-2.5 text-sm font-medium transition-colors duration-150 {{ $catalogActive ? 'bg-white/15 text-white' : 'text-stone-300 hover:bg-white/8 hover:text-white' }}"
                    >
                        <x-lucide-settings-2 class="h-4 w-4 shrink-0 {{ $catalogActive ? 'text-gold' : 'text-stone-400 group-hover:text-stone-200' }}" />
                        Catálogo
                        <x-lucide-chevron-down class="ml-auto h-3.5 w-3.5 transition-transform duration-200" x-bind:class="open ? 'rotate-180' : ''" />
                    </button>

                    <div x-show="open" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="mt-0.5 space-y-0.5">
                        <a
                            href="{{ route('admin.catalog-settings.index') }}"
                            class="flex items-center gap-2 rounded-sm py-2 pl-10 pr-3 text-xs font-medium transition-colors {{ request()->routeIs('admin.catalog-settings.index') ? 'text-gold' : 'text-stone-400 hover:text-stone-200' }}"
                        >
                            <x-lucide-layout-grid class="h-3.5 w-3.5 shrink-0" />
                            Visão geral
                        </a>
                        @foreach ($catalogTypes as $ct)
                            <a
                                href="{{ route('admin.catalog-settings.type', $ct['type']) }}"
                                class="flex items-center gap-2 rounded-sm py-2 pl-10 pr-3 text-xs font-medium transition-colors {{ request()->routeIs('admin.catalog-settings.type') && request()->route('type') === $ct['type'] ? 'text-gold' : 'text-stone-400 hover:text-stone-200' }}"
                            >
                                <span class="h-1 w-1 rounded-full bg-current"></span>
                                {{ $ct['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </nav>

            {{-- User section --}}
            <div class="mx-3 mb-4">
                <div class="rounded-md border border-white/10 bg-black/10 p-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gold/20 text-sm font-bold text-gold ring-1 ring-gold/30">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-white">{{ auth()->user()?->name }}</p>
                            <p class="truncate text-xs text-stone-400">{{ auth()->user()?->email }}</p>
                        </div>
                    </div>

                    <div class="mt-3 border-t border-white/10 pt-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-xs font-medium text-stone-400 transition-colors hover:bg-red-500/15 hover:text-red-400"
                            >
                                <x-lucide-log-out class="h-3.5 w-3.5" />
                                Sair da conta
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex min-h-screen flex-col bg-stone-50">
            <header class="border-b border-stone-200/70 bg-white px-4 py-4 md:px-8">
                <p class="text-xs font-medium uppercase tracking-widest text-stone-400">Painel Admin</p>
                <h1 class="mt-0.5 text-lg font-bold text-stone-900">{{ $title }}</h1>
            </header>

            <main class="flex-1 px-4 py-6 md:px-8">
                @if (session('success'))
                    <x-admin.alert type="success" :message="session('success')" class="mb-5" />
                @endif

                @if (session('error'))
                    <x-admin.alert type="error" :message="session('error')" class="mb-5" />
                @endif

                @if ($errors->any())
                    <x-admin.alert type="error" class="mb-5">
                        <p class="font-semibold">Não foi possível salvar. Confira os campos abaixo.</p>
                    </x-admin.alert>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</x-layouts.public>
