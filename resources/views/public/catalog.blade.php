<x-layouts.public>
    <x-public.header />

    <main class="overflow-hidden">
        <section class="relative overflow-hidden border-b border-stone-200/60 bg-white py-16 md:py-20">
            <div class="pointer-events-none absolute right-0 top-0 h-full w-1/2 bg-[radial-gradient(ellipse_at_80%_50%,rgba(199,161,90,0.07)_0,transparent_60%)]"></div>
            <div class="relative mx-auto w-full max-w-6xl px-4">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gold">
                        <span class="h-px w-5 rounded-full bg-gold"></span>
                        Catálogo completo
                    </span>
                    <h1 class="mt-4 text-4xl font-bold leading-tight tracking-tight text-stone-900 md:text-5xl">
                        Escolha seu perfume ideal
                    </h1>
                    <p class="mt-4 text-lg font-light text-stone-600">
                        Filtre por família olfativa, concentração e ocasião para encontrar a fragrância certa.
                    </p>
                </div>
            </div>
        </section>

        <livewire:public.catalog-grid />
    </main>

    <x-public.footer variant="light" />
</x-layouts.public>
