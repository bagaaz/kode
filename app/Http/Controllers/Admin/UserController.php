<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'is_active' => (bool) ($data['is_active'] ?? false),
            'email_verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario cadastrado com sucesso.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validateData($request, $user);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'role' => $data['role'],
            'is_active' => (bool) ($data['is_active'] ?? false),
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario atualizado com sucesso.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Voce nao pode excluir seu proprio usuario.');
        }

        $user->delete();

        return back()->with('success', 'Usuario excluido com sucesso.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Voce nao pode desativar seu proprio usuario.');
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        return back()->with('success', 'Status do usuario atualizado.');
    }

    private function validateData(Request $request, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'confirmed', Password::min(6)]
            : ['required', 'confirmed', Password::min(6)];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => $passwordRules,
            'role' => ['required', 'in:admin,customer'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
