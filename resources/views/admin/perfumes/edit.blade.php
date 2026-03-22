<x-layouts.admin title="Editar Perfume">
    <section class="space-y-6">
        <div class="rounded-md border border-stone-200 bg-white p-5 shadow-sm">
            <div class="mb-6">
                <h2 class="text-base font-semibold text-stone-900">Editar perfume</h2>
                <p class="mt-1 text-sm text-stone-600">Atualize dados de {{ $perfume->name }}.</p>
            </div>

            @include('admin.perfumes._form', [
                'action' => route('admin.perfumes.update', $perfume),
                'method' => 'PUT',
                'perfume' => $perfume,
                'families' => $families,
                'concentrations' => $concentrations,
                'occasions' => $occasions,
                'intensities' => $intensities,
                'tags' => $tags,
                'submitLabel' => 'Salvar alteracoes',
            ])
        </div>
    </section>
</x-layouts.admin>
