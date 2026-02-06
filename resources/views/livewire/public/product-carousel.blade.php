<section class="{{ trim('py-16 ' . $sectionClass) }}">
    <div class="mx-auto w-full max-w-6xl px-4">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                @if ($subtitle)
                    <span class="inline-flex items-center gap-2 text-sm font-medium uppercase tracking-wide text-amber-600">
                        <x-lucide-sparkles class="h-4 w-4" />
                        {{ $subtitle }}
                    </span>
                @endif
                <h2 class="mt-2 text-3xl font-bold text-stone-900 md:text-4xl">
                    {{ $title }}
                </h2>
            </div>

            @if ($actionLabel && $actionHref)
                <x-ui.button href="{{ $actionHref }}" variant="ghost" icon="lucide-arrow-right">
                    {{ $actionLabel }}
                </x-ui.button>
            @endif
        </div>

        <div>
            <div class="flex gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scroll-smooth">
                @foreach ($products as $product)
                    <div class="w-[85%] shrink-0 snap-start sm:w-[calc((100%-1.5rem)/2)] lg:w-[calc((100%-4.5rem)/4)]">
                        <x-public.product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
