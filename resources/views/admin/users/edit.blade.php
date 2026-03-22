<x-layouts.admin title="Editar Usuario">
    <section class="space-y-6">
        <div class="rounded-md border border-stone-200 bg-white p-5 shadow-sm">
            <div class="mb-6">
                <h2 class="text-base font-semibold text-stone-900">Editar usuario</h2>
                <p class="mt-1 text-sm text-stone-600">Atualize os dados de acesso de {{ $user->name }}.</p>
            </div>

            @include('admin.users._form', [
                'action' => route('admin.users.update', $user),
                'method' => 'PUT',
                'user' => $user,
                'submitLabel' => 'Salvar alteracoes',
            ])
        </div>
    </section>
</x-layouts.admin>
