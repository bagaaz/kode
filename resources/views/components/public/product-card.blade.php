@props(['product'])

@php
    $number      = $product['number'] ?? '00';
    $name        = $product['name'] ?? 'Perfume';
    $description = $product['description'] ?? '';
    $href        = $product['href'] ?? '#';
    $tags        = $product['tags'] ?? [];
    $badge       = $product['badge'] ?? null;
    $image       = $product['image'] ?? null;
    $price       = $product['price'] ?? null;
@endphp

<a href="{{ $href }}" class="group block">
    <article class="relative overflow-hidden rounded-md border border-stone-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1.5 hover:border-gold/40 hover:shadow-lg">

        @if ($badge)
            <span class="absolute left-3 top-3 z-10 rounded-full bg-gold px-2.5 py-1 text-xs font-semibold text-stone-900 shadow-sm">
                {{ $badge }}
            </span>
        @endif

        <div class="aspect-[4/5] overflow-hidden bg-gradient-to-br from-stone-50 via-stone-100 to-gold-muted/20">
            @if ($image)
                <img
                    src="{{ $image }}"
                    alt="{{ $name }}"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    loading="lazy"
                />
            @else
                <div class="flex h-full w-full flex-col items-center justify-center gap-2">
                    <span class="text-7xl font-bold tracking-tighter text-stone-200 transition duration-300 group-hover:text-gold-muted">
                        {{ $number }}
                    </span>
                    <span class="text-xs font-medium uppercase tracking-widest text-stone-300">Kode</span>
                </div>
            @endif
        </div>

        <div class="space-y-3 p-4">
            <div>
                <h3 class="font-bold text-stone-900 transition-colors duration-200 group-hover:text-green">
                    {{ $name }}
                </h3>
                @if ($description)
                    <p class="mt-1 text-sm font-light leading-relaxed text-stone-500 line-clamp-2">
                        {{ $description }}
                    </p>
                @endif
            </div>

            <div class="flex items-center justify-between">
                @if ($price)
                    <p class="text-sm font-semibold text-gold">{{ $price }}</p>
                @endif

                @if (!empty($tags))
                    <div class="flex flex-wrap gap-1.5">
                        @foreach (array_slice($tags, 0, 2) as $tag)
                            <x-ui.badge variant="soft">{{ $tag }}</x-ui.badge>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </article>
</a>
