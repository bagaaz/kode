@props([
    'title'       => '',
    'description' => null,
])

<div class="overflow-hidden rounded-md border border-stone-200 bg-white shadow-sm">
    @if ($title || isset($action))
        <div class="border-b border-stone-200 px-5 py-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    @if ($title)
                        <h2 class="text-base font-semibold text-stone-900">{{ $title }}</h2>
                    @endif
                    @if ($description)
                        <p class="mt-0.5 text-sm text-stone-500">{{ $description }}</p>
                    @endif
                </div>

                @if (isset($action))
                    <div class="shrink-0">{{ $action }}</div>
                @endif
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        {{ $slot }}
    </div>

    @if (isset($footer))
        <div class="border-t border-stone-200 px-5 py-3">
            {{ $footer }}
        </div>
    @endif
</div>
