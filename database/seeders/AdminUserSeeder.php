<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@kode.local');
        $name = env('ADMIN_NAME', 'Administrador Kode');
        $password = env('ADMIN_PASSWORD', 'admin123');

        $admin = User::firstOrNew(['email' => $email]);

        $admin->name = $name;
        $admin->phone = $admin->phone ?? null;
        $admin->role = 'admin';
        $admin->is_active = true;
        $admin->email_verified_at = $admin->email_verified_at ?? now();

        if (! $admin->exists || ! Hash::check($password, (string) $admin->password)) {
            $admin->password = Hash::make($password);
        }

        $admin->save();
    }
}
