<x-layouts.admin title="Dashboard">
    <section class="space-y-8">

        {{-- Stat cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-admin.stat-card
                label="Usuários"
                :value="$totals['users']"
                icon="lucide-users"
            />
            <x-admin.stat-card
                label="Admins"
                :value="$totals['admins']"
                icon="lucide-shield"
                variant="gold"
            />
            <x-admin.stat-card
                label="Perfumes"
                :value="$totals['perfumes']"
                icon="lucide-flask-conical"
            />
            <x-admin.stat-card
                label="Perfumes ativos"
                :value="$totals['active_perfumes']"
                icon="lucide-circle-check"
                variant="green"
            />
        </div>

        {{-- Quick links --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <a href="{{ route('admin.users.index') }}" class="group flex items-start gap-4 rounded-md border border-stone-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-green/30 hover:shadow-md">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-stone-100 transition group-hover:bg-green/10">
                    <x-lucide-users class="h-5 w-5 text-stone-500 transition group-hover:text-green" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-stone-900">Cadastro de usuários</p>
                    <p class="mt-0.5 text-sm text-stone-500">Gerencie acessos, papéis e status do sistema.</p>
                </div>
            </a>

            <a href="{{ route('admin.perfumes.index') }}" class="group flex items-start gap-4 rounded-md border border-stone-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-green/30 hover:shadow-md">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-stone-100 transition group-hover:bg-green/10">
                    <x-lucide-flask-conical class="h-5 w-5 text-stone-500 transition group-hover:text-green" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-stone-900">Cadastro de perfumes</p>
                    <p class="mt-0.5 text-sm text-stone-500">Crie produtos com preço, notas e atributos.</p>
                </div>
            </a>

            <a href="{{ route('admin.catalog-settings.index') }}" class="group flex items-start gap-4 rounded-md border border-stone-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-green/30 hover:shadow-md">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-stone-100 transition group-hover:bg-green/10">
                    <x-lucide-settings-2 class="h-5 w-5 text-stone-500 transition group-hover:text-green" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-stone-900">Taxonomias do catálogo</p>
                    <p class="mt-0.5 text-sm text-stone-500">Famílias, concentrações, tags e coleções.</p>
                </div>
            </a>
        </div>

        {{-- Recent tables --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <x-admin.table-card title="Usuários recentes">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-stone-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Nome</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Perfil</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($recentUsers as $user)
                            <tr class="hover:bg-stone-50/50">
                                <td class="px-4 py-3 font-medium text-stone-900">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-stone-500">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $user->role === 'admin' ? 'bg-gold/15 text-stone-800' : 'bg-stone-100 text-stone-600' }}">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-stone-400">Nenhum usuário cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-admin.table-card>

            <x-admin.table-card title="Perfumes recentes">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-stone-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Código</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Nome</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Preço</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($recentPerfumes as $perfume)
                            <tr class="hover:bg-stone-50/50">
                                <td class="px-4 py-3 font-mono text-xs text-stone-500">{{ $perfume->code }}</td>
                                <td class="px-4 py-3 font-medium text-stone-900">{{ $perfume->name }}</td>
                                <td class="px-4 py-3 text-stone-500">R$ {{ number_format((float) $perfume->price, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-stone-400">Nenhum perfume cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-admin.table-card>
        </div>

    </section>
</x-layouts.admin>
