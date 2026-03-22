<x-layouts.admin title="Configuracoes do Catalogo">
    <section class="space-y-8">
        <div>
            <h2 class="text-base font-semibold text-stone-900">Cadastros auxiliares</h2>
            <p class="mt-1 text-sm text-stone-600">Gerencie opcoes que alimentam filtros e formularios de perfumes.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <x-admin.catalog-card
                title="Familias olfativas"
                :submit-route="route('admin.catalog-settings.families.store')"
                :items="$families"
                type="families"
                name-placeholder="Nome da familia"
            />

            <x-admin.catalog-card
                title="Concentracoes"
                :submit-route="route('admin.catalog-settings.concentrations.store')"
                :items="$concentrations"
                type="concentrations"
                name-placeholder="Nome da concentracao"
            />

            <x-admin.catalog-card
                title="Ocasioes"
                :submit-route="route('admin.catalog-settings.occasions.store')"
                :items="$occasions"
                type="occasions"
                name-placeholder="Nome da ocasiao"
            />

            <x-admin.catalog-card
                title="Intensidades"
                :submit-route="route('admin.catalog-settings.intensities.store')"
                :items="$intensities"
                type="intensities"
                name-placeholder="Nome da intensidade"
            />

            <x-admin.catalog-card
                title="Tags"
                :submit-route="route('admin.catalog-settings.tags.store')"
                :items="$tags"
                type="tags"
                name-placeholder="Nome da tag"
                description-placeholder="Descricao (opcional)"
            />

            <x-admin.catalog-card
                title="Colecoes"
                :submit-route="route('admin.catalog-settings.collections.store')"
                :items="$collections"
                type="collections"
                name-placeholder="Nome da colecao"
                :include-show-on-home="true"
            />
        </div>
    </section>
</x-layouts.admin>
