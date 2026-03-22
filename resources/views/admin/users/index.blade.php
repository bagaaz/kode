<x-layouts.admin title="Cadastro de Usuários">
    <section class="space-y-8">
        <x-admin.table-card
            title="Usuários cadastrados"
            description="Lista de usuários, cargos e status de acesso."
        >
            <x-slot:action>
                <x-ui.button href="{{ route('admin.users.create') }}" size="sm" icon="lucide-plus" icon-position="left">
                    Cadastrar
                </x-ui.button>
            </x-slot:action>

            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Nome</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Perfil</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-stone-500">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($users as $user)
                        <tr class="hover:bg-stone-50/50">
                            <td class="px-4 py-3 font-medium text-stone-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-stone-500">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $user->role === 'admin' ? 'bg-gold/15 text-stone-800' : 'bg-stone-100 text-stone-600' }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $user->is_active ? 'bg-green/10 text-green' : 'bg-red-50 text-red-600' }}">
                                    {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a
                                        href="{{ route('admin.users.edit', $user) }}"
                                        title="Editar"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-sm border border-stone-200 text-stone-600 transition hover:border-stone-300 hover:bg-stone-50"
                                    >
                                        <x-lucide-pencil class="h-3.5 w-3.5" />
                                    </a>
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline-flex">
                                        @csrf @method('PATCH')
                                        <button
                                            type="submit"
                                            title="{{ $user->is_active ? 'Desativar' : 'Ativar' }}"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-sm border border-stone-200 text-stone-600 transition hover:border-stone-300 hover:bg-stone-50"
                                        >
                                            @if ($user->is_active)
                                                <x-lucide-power-off class="h-3.5 w-3.5" />
                                            @else
                                                <x-lucide-power class="h-3.5 w-3.5" />
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-flex" onsubmit="return confirm('Deseja excluir este usuário?');">
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            title="Excluir"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-sm border border-red-100 text-red-500 transition hover:border-red-200 hover:bg-red-50"
                                        >
                                            <x-lucide-trash-2 class="h-3.5 w-3.5" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-stone-400">Nenhum usuário encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <x-slot:footer>
                {{ $users->links() }}
            </x-slot:footer>
        </x-admin.table-card>
    </section>
</x-layouts.admin>
