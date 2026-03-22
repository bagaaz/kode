<section class="{{ trim('py-16 ' . $sectionClass) }}">
    <div class="mx-auto w-full max-w-6xl px-4">
        <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <x-ui.section-heading :label="$subtitle">
                {{ $title }}
            </x-ui.section-heading>

            @if ($actionLabel && $actionHref)
                <x-ui.button href="{{ $actionHref }}" variant="ghost" icon="lucide-arrow-right">
                    {{ $actionLabel }}
                </x-ui.button>
            @endif
        </div>

        <div class="flex gap-5 overflow-x-auto pb-4 snap-x snap-mandatory scroll-smooth">
            @foreach ($products as $product)
                <div class="w-[82%] shrink-0 snap-start sm:w-[calc((100%-1.25rem)/2)] lg:w-[calc((100%-3.75rem)/4)]">
                    <x-public.product-card :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
</section>
