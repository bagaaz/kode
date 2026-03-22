<x-layouts.public>
    <x-public.header />

    <main class="overflow-hidden">

        {{-- Hero --}}
        <section class="relative overflow-hidden bg-green py-24 md:py-36">
            {{-- Dot pattern --}}
            <div class="absolute inset-0 opacity-[0.06] bg-[radial-gradient(circle,rgba(199,161,90,1)_1px,transparent_1px)] bg-[length:28px_28px]"></div>
            {{-- Radial glow --}}
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_50%_0%,rgba(199,161,90,0.12)_0,transparent_65%)]"></div>
            {{-- Large decorative number --}}
            <div class="pointer-events-none absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 select-none text-[22rem] font-bold leading-none tracking-tighter text-stone-50/[0.03] md:text-[28rem]">01</div>

            <div class="relative mx-auto w-full max-w-6xl px-4">
                <div class="mx-auto max-w-3xl text-center">
                    <span class="inline-flex items-center gap-2 rounded-full border border-gold/30 bg-gold/10 px-4 py-1.5 text-sm font-medium text-gold">
                        <x-lucide-sparkles class="h-4 w-4" />
                        Coleção exclusiva
                    </span>

                    <h1 class="mt-8 text-5xl font-bold leading-tight tracking-tight text-stone-50 md:text-7xl">
                        Descubra sua<br>
                        <span class="text-gold">assinatura olfativa</span>
                    </h1>

                    <p class="mt-6 text-lg font-light leading-relaxed text-stone-300">
                        Uma coleção de fragrâncias únicas, numeradas e cuidadosamente desenvolvidas
                        para cada momento da sua vida.
                    </p>

                    <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                        <x-ui.button href="{{ route('catalog') }}" variant="secondary" size="lg" icon="lucide-arrow-right">
                            Explorar catálogo
                        </x-ui.button>
                        <x-ui.button href="{{ $launches[0]['href'] ?? route('catalog') }}" variant="white" size="lg">
                            Ver lançamentos
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Brand pillars --}}
        <section class="border-b border-stone-200/60 bg-white py-14">
            <div class="mx-auto w-full max-w-6xl px-4">
                <div class="grid gap-8 sm:grid-cols-3">
                    <div class="flex flex-col items-center gap-4 text-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full border border-gold/30 bg-gold/10">
                            <x-lucide-sparkles class="h-5 w-5 text-gold" />
                        </div>
                        <div>
                            <h3 class="font-bold text-stone-900">Exclusivas</h3>
                            <p class="mt-1 text-sm font-light text-stone-500">Fragrâncias únicas e em tiragem limitada, criadas para quem valoriza o singular.</p>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-4 text-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full border border-gold/30 bg-gold/10">
                            <x-lucide-flask-conical class="h-5 w-5 text-gold" />
                        </div>
                        <div>
                            <h3 class="font-bold text-stone-900">Artesanais</h3>
                            <p class="mt-1 text-sm font-light text-stone-500">Desenvolvidas com ingredientes selecionados e processo artesanal de alta perfumaria.</p>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-4 text-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full border border-gold/30 bg-gold/10">
                            <x-lucide-hash class="h-5 w-5 text-gold" />
                        </div>
                        <div>
                            <h3 class="font-bold text-stone-900">Numeradas</h3>
                            <p class="mt-1 text-sm font-light text-stone-500">Cada frasco é identificado — sua fragrância tem identidade, história e código próprio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Featured product --}}
        <section class="py-20">
            <div class="mx-auto w-full max-w-6xl px-4">
                <div class="grid gap-12 md:grid-cols-2 md:items-center">
                    <div class="relative aspect-square overflow-hidden rounded-xl bg-gradient-to-br from-stone-100 via-stone-50 to-gold-muted/30 shadow-md">
                        <img
                            src="{{ $featured['image'] ?? asset('images/mini-perfume-exemplo.svg') }}"
                            alt="{{ $featured['name'] }}"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-900/20 to-transparent"></div>
                    </div>

                    <div class="space-y-6">
                        <x-ui.section-heading label="Destaque da coleção">
                            {{ $featured['name'] }}
                        </x-ui.section-heading>

                        <p class="text-base font-light leading-relaxed text-stone-600">
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
            title="Lançamentos"
            subtitle="Novidades"
            :products="$launches"
            action-label="Ver todos"
            :action-href="route('catalog')"
        />

        <livewire:public.product-carousel
            title="Mais vendidos"
            subtitle="Favoritos"
            :products="$bestSellers"
            action-label="Ver catálogo"
            :action-href="route('catalog')"
            section-class="bg-white"
        />

        {{-- CTA --}}
        <section class="bg-green py-20">
            <div class="relative mx-auto w-full max-w-4xl px-4 text-center">
                <div class="absolute inset-0 opacity-[0.05] bg-[radial-gradient(circle,rgba(199,161,90,1)_1px,transparent_1px)] bg-[length:24px_24px]"></div>
                <div class="relative space-y-6">
                    <x-ui.section-heading align="center" size="md">
                        <span class="text-stone-50">Encontre seu</span>
                        <span class="text-gold"> perfume ideal</span>
                    </x-ui.section-heading>
                    <p class="text-base font-light text-stone-300">
                        Use nossos filtros avançados para descobrir a fragrância perfeita para cada ocasião.
                    </p>
                    <x-ui.button href="{{ route('catalog') }}" variant="secondary" size="lg" icon="lucide-arrow-right">
                        Explorar catálogo completo
                    </x-ui.button>
                </div>
            </div>
        </section>

    </main>

    <x-public.footer />
</x-layouts.public>
