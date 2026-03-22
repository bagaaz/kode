@props([
    'label' => null,
    'error' => null,
    'hint'  => null,
    'icon'  => null,
])

<div class="space-y-1.5">
    @if ($label)
        <label class="block text-sm font-medium text-stone-700">{{ $label }}</label>
    @endif

    <div class="relative">
        @if ($icon)
            <div class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-stone-400">
                <x-dynamic-component :component="$icon" class="h-4 w-4" />
            </div>
        @endif

        <input
            {{ $attributes->merge(['class' => 'h-11 w-full rounded-sm border border-stone-300 bg-white px-3 text-sm text-stone-900 placeholder:text-stone-400 transition focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20 disabled:cursor-not-allowed disabled:opacity-50 ' . ($icon ? 'pl-10' : '')]) }}
        />
    </div>

    @if ($error)
        <p class="text-xs text-red-600">{{ $error }}</p>
    @elseif ($hint)
        <p class="text-xs text-stone-500">{{ $hint }}</p>
    @endif
</div>
