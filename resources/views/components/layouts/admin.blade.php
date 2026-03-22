@props([
    'title' => 'Painel Administrativo',
])

<x-layouts.public :title="$title">
    <div class="min-h-screen md:grid md:grid-cols-[260px_minmax(0,1fr)]">
        <aside class="relative flex flex-col gap-6 border-b border-green/30 bg-green px-4 py-5 text-stone-50 md:min-h-screen md:border-b-0 md:border-r md:px-5">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center">
                <img src="{{ asset('/src/brand/logo_white.svg') }}" alt="Kode Perfumaria" class="h-10 w-auto" />
            </a>

            <nav class="flex flex-col gap-1 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-stone-200 hover:bg-white/10 hover:text-white' }} rounded-sm px-3 py-2 transition">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white' : 'text-stone-200 hover:bg-white/10 hover:text-white' }} rounded-sm px-3 py-2 transition">
                    Usuarios
                </a>
                <a href="{{ route('admin.perfumes.index') }}" class="{{ request()->routeIs('admin.perfumes.*') ? 'bg-white/20 text-white' : 'text-stone-200 hover:bg-white/10 hover:text-white' }} rounded-sm px-3 py-2 transition">
                    Perfumes
                </a>
                <a href="{{ route('admin.catalog-settings.index') }}" class="{{ request()->routeIs('admin.catalog-settings.*') ? 'bg-white/20 text-white' : 'text-stone-200 hover:bg-white/10 hover:text-white' }} rounded-sm px-3 py-2 transition">
                    Configuracoes do Catalogo
                </a>
            </nav>

            <div class="mt-auto rounded-sm border border-white/15 bg-white/5 p-3">
                <p class="text-xs uppercase tracking-wide text-stone-200">Sessao</p>
                <p class="mt-1 text-sm font-semibold text-white">{{ auth()->user()?->name }}</p>
                <p class="text-xs text-stone-200">{{ auth()->user()?->email }}</p>
                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full rounded-sm bg-white px-3 py-2 text-sm font-semibold text-green transition hover:bg-stone-100">
                        Sair
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex min-h-screen flex-col bg-stone-50">
            <header class="border-b border-stone-200/70 bg-white px-4 py-4 md:px-8">
                <p class="text-xs font-medium uppercase tracking-wide text-stone-500">Painel Admin</p>
                <h1 class="text-lg font-bold text-stone-900">{{ $title }}</h1>
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
                        <p class="font-semibold">Nao foi possivel salvar. Confira os campos abaixo.</p>
                    </x-admin.alert>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</x-layouts.public>
