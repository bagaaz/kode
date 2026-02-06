<x-layouts.public>
    <x-public.header />

    <main class="overflow-hidden">
        <section class="relative overflow-hidden bg-gradient-to-br from-amber-100 via-stone-100 to-emerald-100 py-16 md:py-20">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_12%_12%,rgba(255,255,255,0.75)_0,transparent_48%),radial-gradient(circle_at_82%_8%,rgba(255,255,255,0.62)_0,transparent_42%)]"></div>
            <div class="relative mx-auto w-full max-w-6xl px-4">
                <div class="max-w-3xl">
                    <span class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-sm font-medium text-amber-700">
                        <x-lucide-sparkles class="h-4 w-4" />
                        Catalogo completo
                    </span>
                    <h1 class="mt-4 text-4xl font-bold leading-tight text-stone-900 md:text-5xl">
                        Escolha seu perfume ideal
                    </h1>
                    <p class="mt-4 text-lg text-stone-700">
                        Filtre por familia olfativa, concentracao e ocasiao para encontrar a fragrancia certa.
                    </p>
                </div>
            </div>
        </section>

        <livewire:public.catalog-grid />
    </main>

    <x-public.footer variant="light" />
</x-layouts.public>
