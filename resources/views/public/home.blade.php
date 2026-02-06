<x-layouts.public>
    <x-public.header />

    <main class="overflow-hidden">
        <section class="relative overflow-hidden bg-gradient-to-br from-amber-100 via-amber-200/70 to-emerald-100 py-20 md:py-28">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(255,255,255,0.7)_0,transparent_55%),radial-gradient(circle_at_80%_10%,rgba(255,255,255,0.6)_0,transparent_45%)]"></div>
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_50%_50%,rgba(120,113,108,0.25)_1px,transparent_1px)] bg-[length:26px_26px]"></div>
            <div class="relative mx-auto w-full max-w-6xl px-4">
                <div class="mx-auto max-w-3xl text-center">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-1.5 text-sm font-medium text-amber-700">
                        <x-lucide-sparkles class="h-4 w-4" />
                        Colecao exclusiva
                    </span>

                    <h1 class="mt-6 text-4xl font-bold leading-tight text-stone-900 md:text-6xl">
                        Descubra sua <span class="text-amber-700">assinatura olfativa</span>
                    </h1>
                    <p class="mt-6 text-lg text-stone-700">
                        Uma colecao de fragrancias unicas, numeradas e cuidadosamente desenvolvidas
                        para cada momento da sua vida.
                    </p>

                    <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                        <x-ui.button
                            href="{{ route('catalog') }}"
                            variant="secondary"
                            size="lg"
                            icon="lucide-arrow-right"
                        >
                            Explorar catalogo
                        </x-ui.button>
                        <x-ui.button
                            href="{{ $launches[0]['href'] ?? route('catalog') }}"
                            variant="outline"
                            size="lg"
                        >
                            Ver lancamentos
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16">
            <div class="mx-auto w-full max-w-6xl px-4">
                <div class="grid gap-12 md:grid-cols-2 md:items-center">
                    <div class="relative aspect-square overflow-hidden rounded-3xl bg-gradient-to-br from-stone-100 via-amber-100 to-stone-200">
                        <img
                            src="{{ $featured['image'] ?? asset('images/mini-perfume-exemplo.svg') }}"
                            alt="{{ $featured['name'] }}"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-900/20 to-transparent"></div>
                    </div>
                    <div class="space-y-6">
                        <span class="inline-flex items-center gap-2 text-sm font-medium uppercase tracking-wide text-amber-600">
                            <x-lucide-star class="h-4 w-4" />
                            Destaque da colecao
                        </span>
                        <h2 class="text-4xl font-bold text-stone-900 md:text-5xl">
                            {{ $featured['name'] }}
                        </h2>
                        <p class="text-lg text-stone-600">
                            {{ $featured['description'] }}
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($featured['tags'] as $tag)
                                <x-ui.badge variant="gold">{{ $tag }}</x-ui.badge>
                            @endforeach
                        </div>
                        <x-ui.button href="{{ $featured['href'] }}" icon="lucide-arrow-right">
                            Ver detalhes
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </section>

        <livewire:public.product-carousel
            title="Lancamentos"
            subtitle="Novidades"
            :products="$launches"
            action-label="Ver todos"
            :action-href="route('catalog')"
        />

        <livewire:public.product-carousel
            title="Mais vendidos"
            subtitle="Favoritos"
            :products="$bestSellers"
            action-label="Ver catalogo"
            :action-href="route('catalog')"
            section-class="bg-stone-100/70"
        />

        <section class="bg-gradient-to-r from-stone-900 via-stone-800 to-stone-900 py-20">
            <div class="mx-auto w-full max-w-4xl px-4 text-center">
                <h2 class="text-3xl font-bold text-stone-50 md:text-4xl">
                    Encontre seu perfume ideal
                </h2>
                <p class="mt-4 text-lg text-stone-300">
                    Use nossos filtros avancados para descobrir a fragrancia perfeita para cada ocasiao.
                </p>
                <x-ui.button
                    href="{{ route('catalog') }}"
                    variant="secondary"
                    size="lg"
                    icon="lucide-arrow-right"
                    class="mt-8"
                >
                    Explorar catalogo completo
                </x-ui.button>
            </div>
        </section>
    </main>

    <x-public.footer />
</x-layouts.public>
