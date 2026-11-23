<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Create the first admin user for a local environment.
     *
     * No credentials live in the repository: the e-mail and the password come
     * from .env (SEED_ADMIN_EMAIL, SEED_ADMIN_PASSWORD). Without a password,
     * a random one is generated and printed once.
     */
    public function run(): void
    {
        $email = env('SEED_ADMIN_EMAIL') ?: 'admin@example.com';

        if (User::where('email', $email)->exists()) {
            return;
        }

        $password = env('SEED_ADMIN_PASSWORD');
        $generated = ! $password;
        $password = $password ?: Str::password(16, symbols: false);

        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->command->info("✓ Admin criado: {$email}");

        if ($generated) {
            $this->command->warn("  Senha gerada (anote, ela não aparece de novo): {$password}");
        }
    }
}
