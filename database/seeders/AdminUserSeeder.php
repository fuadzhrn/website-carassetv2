<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * Creates the first CarAsset admin account from environment variables.
     * Safe to run repeatedly: if the admin email already exists, this
     * seeder leaves the existing account (and its password) untouched.
     */
    public function run(): void
    {
        $name = env('ADMIN_NAME');
        $username = env('ADMIN_USERNAME');
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $name || ! $email || ! $password) {
            $this->command?->error(
                'AdminUserSeeder dibatalkan: ADMIN_NAME, ADMIN_EMAIL, dan ADMIN_PASSWORD wajib diisi di .env sebelum menjalankan seeder ini.'
            );

            return;
        }

        if (User::where('email', $email)->exists()) {
            $this->command?->info("AdminUserSeeder dilewati: akun dengan email {$email} sudah ada.");

            return;
        }

        User::create([
            'name' => $name,
            'username' => $username ?: null,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->command?->info('Akun admin CarAsset berhasil dibuat.');
    }
}
