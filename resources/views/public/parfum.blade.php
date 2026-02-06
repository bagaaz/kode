@php
    $rawName = (string) request()->route('name', '07');
    $number = preg_match('/^\d+$/', $rawName) ? str_pad($rawName, 2, '0', STR_PAD_LEFT) : strtoupper($rawName);

    $product = [
        'name' => "Perfume {$number}",
        'subtitle' => 'Eau de Parfum',
        'price' => 'R$ 259,90',
        'rating' => 4.8,
        'reviews' => 124,
        'description' => 'Uma fragrancia sofisticada com saida citrica luminosa, coracao floral elegante e fundo amadeirado quente. Desenvolvida para uso versatil, do dia a noite.',
        'family' => 'Amadeirado aromatico',
        'fixation' => '8 a 10 horas',
        'projection' => 'Moderada',
        'gender' => 'Unissex',
        'image' => asset('/src/images/mini-perfume-exemplo.jpg'),
        'notes' => [
            'Topo: bergamota, limao siciliano, cardamomo',
            'Coracao: lavanda francesa, iris, flor de laranjeira',
            'Fundo: vetiver haitiano, cedro, ambroxan',
        ],
    ];

    $gallery = [
        ['label' => 'Frente', 'hint' => 'frasco'],
        ['label' => 'Lateral', 'hint' => 'detalhe'],
        ['label' => 'Textura', 'hint' => 'vidro'],
        ['label' => 'Caixa', 'hint' => 'embalagem'],
    ];

    $related = [
        ['number' => '03', 'name' => 'Santal 03', 'price' => 'R$ 259,90', 'tag' => 'Noturno'],
        ['number' => '05', 'name' => 'Noir 05', 'price' => 'R$ 299,90', 'tag' => 'Intenso'],
        ['number' => '09', 'name' => 'Mineral 09', 'price' => 'R$ 209,90', 'tag' => 'Fresco'],
        ['number' => '12', 'name' => 'Oud 12', 'price' => 'R$ 319,90', 'tag' => 'Marcante'],
    ];
@endphp

<x-layouts.public>
    <x-public.header />

    <main class="overflow-hidden">
        <section class="border-b border-stone-200/70 bg-gradient-to-br from-amber-100 via-stone-100 to-emerald-100 py-10">
            <div class="mx-auto w-full max-w-6xl px-4">
                <nav aria-label="Breadcrumb" class="mb-4 text-sm text-stone-600">
                    <ol class="flex items-center gap-2">
                        <li><a href="{{ route('home') }}" class="transition hover:text-stone-900">Home</a></li>
                        <li>/</li>
                        <li><a href="{{ route('catalog') }}" class="transition hover:text-stone-900">Catalogo</a></li>
                        <li>/</li>
                        <li class="font-medium text-stone-900">{{ $product['name'] }}</li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-stone-900 md:text-4xl">{{ $product['name'] }}</h1>
                <p class="mt-2 text-stone-700">{{ $product['subtitle'] }}</p>
            </div>
        </section>

        <section class="py-10 md:py-12">
            <div class="mx-auto w-full max-w-6xl px-4">
                <div class="grid gap-10 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)]">
                    <div>
                        <div class="relative overflow-hidden rounded-md border border-stone-200">
                            <img
                                src="{{ $product['image'] }}"
                                alt="{{ $product['name'] }}"
                                class="aspect-square w-full object-cover"
                            />
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
                            @foreach ($gallery as $item)
                                <div class="group relative overflow-hidden rounded-sm border border-stone-200 bg-stone-100">
                                    <img
                                        src="{{ $product['image'] }}"
                                        alt="{{ $item['label'] }} de {{ $product['name'] }}"
                                        class="aspect-square w-full object-cover transition duration-300 group-hover:scale-105"
                                    />
                                    <div class="absolute inset-x-0 bottom-0 bg-stone-900/55 px-2 py-1 text-[11px] uppercase tracking-wide text-stone-50">
                                        {{ $item['label'] }} · {{ $item['hint'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <div class="mb-4 flex items-center gap-2">
                            <x-ui.badge variant="gold">Mock</x-ui.badge>
                            <x-ui.badge variant="green">{{ $product['family'] }}</x-ui.badge>
                        </div>

                        <p class="text-3xl font-bold text-stone-900">{{ $product['price'] }}</p>

                        <div class="mt-4 flex items-center gap-3 text-sm text-stone-600">
                            <div class="flex items-center gap-0.5 text-amber-500">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-5 w-5">
                                        <path d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" />
                                    </svg>
                                @endfor
                            </div>
                            <span>{{ number_format($product['rating'], 1, ',', '.') }} ({{ $product['reviews'] }} avaliacoes)</span>
                        </div>

                        <p class="mt-6 text-base leading-relaxed text-stone-700">
                            {{ $product['description'] }}
                        </p>

                        <div class="mt-6 grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-sm border border-stone-200 px-3 py-2">
                                <p class="text-stone-500">Fixacao</p>
                                <p class="font-medium text-stone-900">{{ $product['fixation'] }}</p>
                            </div>
                            <div class="rounded-sm border border-stone-200 px-3 py-2">
                                <p class="text-stone-500">Projecao</p>
                                <p class="font-medium text-stone-900">{{ $product['projection'] }}</p>
                            </div>
                            <div class="rounded-sm border border-stone-200 px-3 py-2">
                                <p class="text-stone-500">Publico</p>
                                <p class="font-medium text-stone-900">{{ $product['gender'] }}</p>
                            </div>
                            <div class="rounded-sm border border-stone-200 px-3 py-2">
                                <p class="text-stone-500">Concentracao</p>
                                <p class="font-medium text-stone-900">{{ $product['subtitle'] }}</p>
                            </div>
                        </div>

                        <form class="mt-8 space-y-6">
                            <div>
                                <h3 class="text-sm font-medium text-stone-700">Volume</h3>
                                <fieldset class="mt-2 grid grid-cols-3 gap-2">
                                    <label class="cursor-pointer rounded-sm border border-stone-300 px-3 py-2 text-center text-sm font-medium text-stone-900">
                                        <input type="radio" name="volume" class="sr-only" checked />
                                        50ml
                                    </label>
                                    <label class="cursor-pointer rounded-sm border border-stone-300 px-3 py-2 text-center text-sm font-medium text-stone-900">
                                        <input type="radio" name="volume" class="sr-only" />
                                        100ml
                                    </label>
                                    <label class="cursor-pointer rounded-sm border border-stone-300 px-3 py-2 text-center text-sm font-medium text-stone-900">
                                        <input type="radio" name="volume" class="sr-only" />
                                        150ml
                                    </label>
                                </fieldset>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-stone-700">Entrega</h3>
                                <p class="mt-1 text-sm text-stone-600">Frete gratis acima de R$ 249,00 para Sudeste.</p>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row">
                                <x-ui.button class="sm:flex-1">Adicionar ao carrinho</x-ui.button>
                                <x-ui.button variant="outline" class="sm:flex-1">Salvar nos favoritos</x-ui.button>
                            </div>
                        </form>

                        <section class="mt-10 border-t border-stone-200">
                            <h2 class="sr-only">Detalhes adicionais</h2>

                            <details open class="border-b border-stone-200 py-5">
                                <summary class="cursor-pointer text-sm font-semibold text-stone-900">Piramide olfativa</summary>
                                <ul class="mt-3 space-y-2 text-sm text-stone-700">
                                    @foreach ($product['notes'] as $note)
                                        <li>{{ $note }}</li>
                                    @endforeach
                                </ul>
                            </details>

                            <details class="border-b border-stone-200 py-5">
                                <summary class="cursor-pointer text-sm font-semibold text-stone-900">Cuidados</summary>
                                <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-stone-700">
                                    <li>Guardar em local fresco e longe da luz direta.</li>
                                    <li>Evitar aplicar em roupas claras delicadas.</li>
                                    <li>Manter frasco fechado apos o uso.</li>
                                </ul>
                            </details>

                            <details class="border-b border-stone-200 py-5">
                                <summary class="cursor-pointer text-sm font-semibold text-stone-900">Envio e devolucao</summary>
                                <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-stone-700">
                                    <li>Envio em ate 24h uteis apos confirmacao do pagamento.</li>
                                    <li>Prazo medio: 2 a 6 dias uteis (Brasil).</li>
                                    <li>Devolucao em ate 7 dias corridos para produtos sem uso.</li>
                                </ul>
                            </details>
                        </section>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-t border-stone-200 bg-stone-100/60 py-14">
            <div class="mx-auto w-full max-w-6xl px-4">
                <div class="mb-6 flex items-end justify-between gap-4">
                    <h2 class="text-2xl font-bold text-stone-900 md:text-3xl">Voce tambem pode gostar</h2>
                    <a href="{{ route('catalog') }}" class="text-sm font-medium text-stone-700 transition hover:text-stone-900">Ver catalogo completo</a>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($related as $item)
                        <a href="{{ route('parfum', ['name' => $item['number']]) }}" class="group block">
                            <article class="overflow-hidden rounded-md border border-stone-200 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                                <img src="{{ $product['image'] }}" alt="{{ $item['name'] }}" class="aspect-square w-full object-cover" />
                                <div class="space-y-2 p-4">
                                    <div class="flex items-center justify-between gap-2">
                                        <h3 class="text-base font-semibold text-stone-900">{{ $item['name'] }}</h3>
                                        <x-ui.badge>{{ $item['tag'] }}</x-ui.badge>
                                    </div>
                                    <p class="text-sm text-stone-600">{{ $item['price'] }}</p>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <x-public.footer variant="light" />
</x-layouts.public>
