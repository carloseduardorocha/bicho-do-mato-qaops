<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@admin.com';
        $user  = User::where('email', $email)->first();

        if (!$user) {
            User::create([
                'name'     => 'Admin',
                'email'    => $email,
                'password' => Hash::make('admin123'),
            ]);

            $this->command->info('✓ Usuário criado com sucesso!');
            $this->command->info('  Email: admin@admin.com | Senha: admin123');
        }
    }
}
