<x-layouts.admin title="Dashboard">
    <section class="space-y-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-md border border-stone-200 bg-white p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-stone-500">Usuarios</p>
                <p class="mt-2 text-3xl font-bold text-stone-900">{{ $totals['users'] }}</p>
            </article>
            <article class="rounded-md border border-stone-200 bg-white p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-stone-500">Admins</p>
                <p class="mt-2 text-3xl font-bold text-stone-900">{{ $totals['admins'] }}</p>
            </article>
            <article class="rounded-md border border-stone-200 bg-white p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-stone-500">Perfumes</p>
                <p class="mt-2 text-3xl font-bold text-stone-900">{{ $totals['perfumes'] }}</p>
            </article>
            <article class="rounded-md border border-stone-200 bg-white p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-stone-500">Perfumes ativos</p>
                <p class="mt-2 text-3xl font-bold text-stone-900">{{ $totals['active_perfumes'] }}</p>
            </article>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <a href="{{ route('admin.users.index') }}" class="rounded-md border border-stone-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow">
                <p class="text-sm font-semibold text-stone-900">Cadastro de usuarios</p>
                <p class="mt-1 text-sm text-stone-600">Gerencie acessos, papeis e status do sistema.</p>
            </a>
            <a href="{{ route('admin.perfumes.index') }}" class="rounded-md border border-stone-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow">
                <p class="text-sm font-semibold text-stone-900">Cadastro de perfumes</p>
                <p class="mt-1 text-sm text-stone-600">Crie produtos com preco, notas e atributos.</p>
            </a>
            <a href="{{ route('admin.catalog-settings.index') }}" class="rounded-md border border-stone-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow">
                <p class="text-sm font-semibold text-stone-900">Taxonomias do catalogo</p>
                <p class="mt-1 text-sm text-stone-600">Familias, concentracoes, tags e colecoes.</p>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="overflow-hidden rounded-md border border-stone-200 bg-white shadow-sm">
                <div class="border-b border-stone-200 px-4 py-3">
                    <h2 class="text-sm font-semibold text-stone-900">Usuarios recentes</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-stone-200 text-sm">
                        <thead class="bg-stone-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-stone-800">Nome</th>
                                <th class="px-4 py-3 text-left font-semibold text-stone-800">Email</th>
                                <th class="px-4 py-3 text-left font-semibold text-stone-800">Perfil</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($recentUsers as $user)
                                <tr>
                                    <td class="px-4 py-3 text-stone-900">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-stone-600">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full bg-stone-100 px-2 py-1 text-xs font-semibold text-stone-700">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-5 text-center text-stone-500">Nenhum usuario cadastrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="overflow-hidden rounded-md border border-stone-200 bg-white shadow-sm">
                <div class="border-b border-stone-200 px-4 py-3">
                    <h2 class="text-sm font-semibold text-stone-900">Perfumes recentes</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-stone-200 text-sm">
                        <thead class="bg-stone-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-stone-800">Codigo</th>
                                <th class="px-4 py-3 text-left font-semibold text-stone-800">Nome</th>
                                <th class="px-4 py-3 text-left font-semibold text-stone-800">Preco</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($recentPerfumes as $perfume)
                                <tr>
                                    <td class="px-4 py-3 text-stone-600">{{ $perfume->code }}</td>
                                    <td class="px-4 py-3 text-stone-900">{{ $perfume->name }}</td>
                                    <td class="px-4 py-3 text-stone-600">R$ {{ number_format((float) $perfume->price, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-5 text-center text-stone-500">Nenhum perfume cadastrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-layouts.admin>
