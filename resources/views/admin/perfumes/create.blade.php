<x-layouts.admin title="Cadastrar Perfume">
    <section class="space-y-6">
        @if ($families->isEmpty() || $concentrations->isEmpty() || $occasions->isEmpty() || $intensities->isEmpty())
            <x-admin.alert type="warning">
                Antes de cadastrar perfumes, preencha familias, concentracoes, ocasioes e intensidades em
                <a href="{{ route('admin.catalog-settings.index') }}" class="font-semibold underline">Configuracoes do Catalogo</a>.
            </x-admin.alert>
        @endif

        <div class="rounded-md border border-stone-200 bg-white p-5 shadow-sm">
            <div class="mb-6">
                <h2 class="text-base font-semibold text-stone-900">Novo perfume</h2>
                <p class="mt-1 text-sm text-stone-600">Cadastro completo de produto com atributos exibidos nos mocks.</p>
            </div>

            @include('admin.perfumes._form', [
                'action' => route('admin.perfumes.store'),
                'method' => 'POST',
                'families' => $families,
                'concentrations' => $concentrations,
                'occasions' => $occasions,
                'intensities' => $intensities,
                'tags' => $tags,
                'submitLabel' => 'Cadastrar perfume',
            ])
        </div>
    </section>
</x-layouts.admin>
