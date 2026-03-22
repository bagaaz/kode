<x-layouts.public :title="$perfume->name . ' — Kode Perfumaria'">
    <x-public.header />

    <main class="overflow-hidden">

        {{-- Breadcrumb + título --}}
        <section class="relative overflow-hidden border-b border-stone-200/60 bg-white py-10">
            <div class="pointer-events-none absolute right-0 top-0 h-full w-1/3 bg-[radial-gradient(ellipse_at_80%_50%,rgba(199,161,90,0.07)_0,transparent_60%)]"></div>
            <div class="relative mx-auto w-full max-w-6xl px-4">
                <nav aria-label="Breadcrumb" class="mb-5 text-xs text-stone-400">
                    <ol class="flex items-center gap-2">
                        <li><a href="{{ route('home') }}" class="transition hover:text-stone-700">Home</a></li>
                        <li class="text-stone-300">/</li>
                        <li><a href="{{ route('catalog') }}" class="transition hover:text-stone-700">Catálogo</a></li>
                        <li class="text-stone-300">/</li>
                        <li class="font-medium text-stone-600">{{ $perfume->name }}</li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold tracking-tight text-stone-900 md:text-4xl">{{ $perfume->name }}</h1>
                <p class="mt-2 text-sm font-medium uppercase tracking-widest text-gold">{{ $perfume->concentration?->name ?? $perfume->subtitle }}</p>
            </div>
        </section>

        {{-- Produto principal --}}
        <section class="py-10 md:py-14">
            <div class="mx-auto w-full max-w-6xl px-4">
                <div class="grid gap-12 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)]">

                    {{-- Galeria --}}
                    <div>
                        <div class="relative overflow-hidden rounded-xl border border-stone-200/80 shadow-sm">
                            <img
                                src="{{ $primaryImage ?? asset('/src/images/mini-perfume-exemplo.jpg') }}"
                                alt="{{ $perfume->name }}"
                                class="aspect-square w-full object-cover"
                            />
                        </div>

                        @if (!empty($gallery))
                            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                                @foreach ($gallery as $item)
                                    <div class="group relative overflow-hidden rounded-sm border border-stone-200 bg-stone-100">
                                        <img
                                            src="{{ $item['url'] }}"
                                            alt="{{ $item['label'] }} de {{ $perfume->name }}"
                                            class="aspect-square w-full object-cover transition duration-300 group-hover:scale-105"
                                        />
                                        <div class="absolute inset-x-0 bottom-0 bg-stone-900/55 px-2 py-1 text-[11px] uppercase tracking-wide text-stone-50">
                                            {{ $item['label'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Informações --}}
                    <div>
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            @if ($perfume->fragranceFamily)
                                <x-ui.badge variant="gold">{{ $perfume->fragranceFamily->name }}</x-ui.badge>
                            @endif
                            @if ($perfume->concentration)
                                <x-ui.badge variant="green">{{ $perfume->concentration->name }}</x-ui.badge>
                            @endif
                        </div>

                        <p class="text-3xl font-bold tracking-tight text-stone-900">
                            R$ {{ number_format((float) $perfume->price, 2, ',', '.') }}
                        </p>

                        @if ($perfume->score)
                            <div class="mt-4 flex items-center gap-2 text-sm text-stone-500">
                                <div class="flex items-center gap-0.5 text-amber-400">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg viewBox="0 0 20 20" fill="{{ $i < round($perfume->score / 20) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" aria-hidden="true" class="h-4 w-4">
                                            <path d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span>Score {{ $perfume->score }}/100</span>
                            </div>
                        @endif

                        @if ($perfume->short_description || $perfume->description)
                            <p class="mt-6 text-base leading-relaxed text-stone-600">
                                {{ $perfume->short_description ?? $perfume->description }}
                            </p>
                        @endif

                        {{-- Atributos --}}
                        <div class="mt-6 grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-sm border border-stone-200 px-3 py-2.5">
                                <p class="text-xs text-stone-400">Fixação</p>
                                <p class="mt-0.5 font-medium text-stone-900">{{ $fixation }}</p>
                            </div>
                            <div class="rounded-sm border border-stone-200 px-3 py-2.5">
                                <p class="text-xs text-stone-400">Projeção</p>
                                <p class="mt-0.5 font-medium text-stone-900">{{ $perfume->projection ?? '—' }}</p>
                            </div>
                            <div class="rounded-sm border border-stone-200 px-3 py-2.5">
                                <p class="text-xs text-stone-400">Público</p>
                                <p class="mt-0.5 font-medium text-stone-900">{{ ucfirst($perfume->audience ?? '—') }}</p>
                            </div>
                            <div class="rounded-sm border border-stone-200 px-3 py-2.5">
                                <p class="text-xs text-stone-400">Ocasião</p>
                                <p class="mt-0.5 font-medium text-stone-900">{{ $perfume->occasion?->name ?? '—' }}</p>
                            </div>
                        </div>

                        {{-- Volume --}}
                        <form x-data="{ volume: '{{ $volumes[0] ?? '50ml' }}' }" class="mt-8 space-y-6">
                            <div>
                                <h3 class="text-sm font-medium text-stone-700">Volume</h3>
                                <fieldset class="mt-2 grid grid-cols-3 gap-2">
                                    @foreach ($volumes as $vol)
                                        <label
                                            @click="volume = '{{ $vol }}'"
                                            :class="volume === '{{ $vol }}'
                                                ? 'border-green bg-green/5 text-green'
                                                : 'border-stone-200 text-stone-700 hover:border-stone-300'"
                                            class="cursor-pointer rounded-sm border px-3 py-2.5 text-center text-sm font-medium transition-colors duration-150"
                                        >
                                            {{ $vol }}
                                        </label>
                                    @endforeach
                                </fieldset>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-stone-700">Entrega</h3>
                                <p class="mt-1 text-sm text-stone-500">Frete grátis acima de R$ 249,00 para o Sudeste.</p>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row">
                                <x-ui.button class="sm:flex-1">Adicionar ao carrinho</x-ui.button>
                                <x-ui.button variant="outline" class="sm:flex-1">Salvar nos favoritos</x-ui.button>
                            </div>
                        </form>

                        {{-- Detalhes expansíveis --}}
                        @if (!empty($notes))
                            <section class="mt-10 border-t border-stone-200">
                                <details open class="group border-b border-stone-200 py-5">
                                    <summary class="flex cursor-pointer items-center justify-between text-sm font-semibold text-stone-900 [&::-webkit-details-marker]:hidden">
                                        <span class="flex items-center gap-2">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gold"></span>
                                            Pirâmide olfativa
                                        </span>
                                        <x-lucide-chevron-down class="h-4 w-4 text-stone-400 transition-transform group-open:rotate-180" />
                                    </summary>
                                    <ul class="mt-4 space-y-2.5 text-sm text-stone-600">
                                        @foreach ($notes as $note)
                                            <li class="flex items-start gap-2">
                                                <span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-gold-muted"></span>
                                                {{ $note }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </details>

                                <details class="group border-b border-stone-200 py-5">
                                    <summary class="flex cursor-pointer items-center justify-between text-sm font-semibold text-stone-900 [&::-webkit-details-marker]:hidden">
                                        <span class="flex items-center gap-2">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gold"></span>
                                            Cuidados
                                        </span>
                                        <x-lucide-chevron-down class="h-4 w-4 text-stone-400 transition-transform group-open:rotate-180" />
                                    </summary>
                                    <ul class="mt-4 space-y-2 text-sm text-stone-600">
                                        <li class="flex items-start gap-2"><span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-gold-muted"></span>Guardar em local fresco e longe da luz direta.</li>
                                        <li class="flex items-start gap-2"><span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-gold-muted"></span>Evitar aplicar em roupas claras delicadas.</li>
                                        <li class="flex items-start gap-2"><span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-gold-muted"></span>Manter frasco fechado após o uso.</li>
                                    </ul>
                                </details>

                                <details class="group border-b border-stone-200 py-5">
                                    <summary class="flex cursor-pointer items-center justify-between text-sm font-semibold text-stone-900 [&::-webkit-details-marker]:hidden">
                                        <span class="flex items-center gap-2">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gold"></span>
                                            Envio e devolução
                                        </span>
                                        <x-lucide-chevron-down class="h-4 w-4 text-stone-400 transition-transform group-open:rotate-180" />
                                    </summary>
                                    <ul class="mt-4 space-y-2 text-sm text-stone-600">
                                        <li class="flex items-start gap-2"><span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-gold-muted"></span>Envio em até 24h úteis após confirmação do pagamento.</li>
                                        <li class="flex items-start gap-2"><span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-gold-muted"></span>Prazo médio: 2 a 6 dias úteis (Brasil).</li>
                                        <li class="flex items-start gap-2"><span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-gold-muted"></span>Devolução em até 7 dias corridos para produtos sem uso.</li>
                                    </ul>
                                </details>
                            </section>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- Relacionados --}}
        @if (!empty($related))
            <section class="border-t border-stone-200/60 bg-stone-50/60 py-14">
                <div class="mx-auto w-full max-w-6xl px-4">
                    <div class="mb-8 flex items-end justify-between gap-4">
                        <x-ui.section-heading label="Da mesma família">
                            Você também pode gostar
                        </x-ui.section-heading>
                        <a href="{{ route('catalog') }}" class="shrink-0 text-sm font-medium text-stone-500 transition hover:text-stone-900">
                            Ver catálogo
                        </a>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($related as $item)
                            <a href="{{ $item['href'] }}" class="group block">
                                <article class="overflow-hidden rounded-md border border-stone-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-gold/40 hover:shadow-md">
                                    <div class="aspect-square overflow-hidden bg-gradient-to-br from-stone-50 to-stone-100">
                                        @if ($item['image'])
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center">
                                                <span class="text-5xl font-bold text-stone-200">{{ $item['number'] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="space-y-1.5 p-4">
                                        <div class="flex items-center justify-between gap-2">
                                            <h3 class="text-sm font-semibold text-stone-900 group-hover:text-green transition-colors">{{ $item['name'] }}</h3>
                                            <x-ui.badge variant="soft">{{ $item['tag'] }}</x-ui.badge>
                                        </div>
                                        <p class="text-sm font-medium text-gold">{{ $item['price'] }}</p>
                                    </div>
                                </article>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </main>

    <x-public.footer variant="light" />
</x-layouts.public>
