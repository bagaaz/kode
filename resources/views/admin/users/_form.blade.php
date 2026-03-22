@props([
    'action',
    'method' => 'POST',
    'user' => null,
    'submitLabel' => 'Salvar',
])

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-stone-800">Nome</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user?->name) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-stone-800">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user?->email) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" required />
        </div>

        <div>
            <label for="phone" class="mb-1 block text-sm font-medium text-stone-800">Telefone</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $user?->phone) }}" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" />
        </div>

        <div>
            <label for="role" class="mb-1 block text-sm font-medium text-stone-800">Perfil</label>
            <select id="role" name="role" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20">
                <option value="customer" @selected(old('role', $user?->role) === 'customer')>Cliente</option>
                <option value="admin" @selected(old('role', $user?->role) === 'admin')>Admin</option>
            </select>
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-stone-800">
                {{ $user ? 'Nova senha (opcional)' : 'Senha' }}
            </label>
            <input id="password" name="password" type="password" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" {{ $user ? '' : 'required' }} />
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-stone-800">Confirmar senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-sm border border-stone-300 px-3 py-2 text-sm focus:border-green focus:outline-none focus:ring-2 focus:ring-green/20" {{ $user ? '' : 'required' }} />
        </div>
    </div>

    <div class="flex items-center justify-between border-t border-stone-200 pt-4">
        <label class="inline-flex items-center gap-2 text-sm text-stone-700">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user?->is_active ?? true)) class="h-4 w-4 rounded-sm border-stone-300 text-green focus:ring-green/30" />
            Usuario ativo
        </label>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.index') }}" class="rounded-sm border border-stone-300 px-3 py-2 text-sm font-semibold text-stone-700 transition hover:bg-stone-100">
                Cancelar
            </a>
            <button type="submit" class="rounded-sm bg-green px-4 py-2 text-sm font-semibold text-stone-50 transition hover:bg-green-hover">
                {{ $submitLabel }}
            </button>
        </div>
    </div>
</form>
