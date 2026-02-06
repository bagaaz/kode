@props(['product'])

@php
    $number = $product['number'] ?? '00';
    $name = $product['name'] ?? 'Perfume';
    $description = $product['description'] ?? '';
    $href = $product['href'] ?? '#';
    $tags = $product['tags'] ?? [];
    $badge = $product['badge'] ?? null;
    $image = $product['image'] ?? null;
    $price = $product['price'] ?? null;
@endphp

<a href="{{ $href }}" class="group block">
    <article class="relative overflow-hidden rounded-2xl border border-stone-100 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
        @if ($badge)
            <span class="absolute left-3 top-3 rounded-full bg-amber-300 px-2 py-1 text-xs font-medium text-stone-900">
                {{ $badge }}
            </span>
        @endif

        <div class="aspect-square overflow-hidden bg-gradient-to-br from-stone-100 via-stone-50 to-amber-100/70">
            @if ($image)
                <img
                    src="{{ $image }}"
                    alt="{{ $name }}"
                    class="h-full w-full object-cover"
                    loading="lazy"
                />
            @else
                <div class="flex h-full w-full items-center justify-center">
                    <span class="text-6xl font-bold text-stone-300 transition group-hover:text-stone-400">
                        {{ $number }}
                    </span>
                </div>
            @endif
        </div>

        <div class="space-y-3 p-4">
            <div>
                <h3 class="text-lg font-bold text-stone-900 transition group-hover:text-stone-700">
                    {{ $name }}
                </h3>
                <p class="mt-1 text-sm font-light text-stone-600 line-clamp-2">
                    {{ $description }}
                </p>
                @if ($price)
                    <p class="mt-2 text-sm font-semibold text-green">
                        {{ $price }}
                    </p>
                @endif
            </div>

            @if (!empty($tags))
                <div class="flex flex-wrap gap-2">
                    @foreach ($tags as $tag)
                        <x-ui.badge variant="green">{{ $tag }}</x-ui.badge>
                    @endforeach
                </div>
            @endif
        </div>
    </article>
</a>
