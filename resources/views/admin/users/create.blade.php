<x-layouts.admin title="Cadastrar Usuario">
    <section class="space-y-6">
        <div class="rounded-md border border-stone-200 bg-white p-5 shadow-sm">
            <div class="mb-6">
                <h2 class="text-base font-semibold text-stone-900">Novo usuario</h2>
                <p class="mt-1 text-sm text-stone-600">Preencha os dados para criar um novo acesso.</p>
            </div>

            <x-admin.alert type="warning" class="mb-6">
                Crie senhas fortes e compartilhe os acessos apenas com usuarios autorizados.
            </x-admin.alert>

            @include('admin.users._form', [
                'action' => route('admin.users.store'),
                'method' => 'POST',
                'submitLabel' => 'Cadastrar usuario',
            ])
        </div>
    </section>
</x-layouts.admin>
