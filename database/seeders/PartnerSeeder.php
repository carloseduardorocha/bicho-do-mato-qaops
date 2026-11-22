<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Copiar imagem padrão para storage se não existir
        $this->copyDefaultImage();

        $partners = [
            [
                Partner::NAME => 'Universidade Federal de Santa Maria',
                Partner::IMAGE => 'partners/ufsm_logo.png',
                Partner::LINK => 'https://www.ufsm.br',
            ],
            [
                Partner::NAME => 'Universidade Federal de Santa Maria',
                Partner::IMAGE => 'partners/ufsm_logo.png',
                Partner::LINK => 'https://www.ufsm.br',
            ],
            [
                Partner::NAME => 'Universidade Federal de Santa Maria',
                Partner::IMAGE => 'partners/ufsm_logo.png',
                Partner::LINK => 'https://www.ufsm.br',
            ],
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }

        $this->command->info('✓ 3 Parceiros criados com sucesso!');
    }

    /**
     * Copia a imagem padrão para o storage
     */
    private function copyDefaultImage(): void
    {
        $sourcePath = public_path('images/default/parceiros/ufsm_logo.png');
        $destPath = storage_path('app/public/partners/ufsm_logo.png');

        // Criar diretório se não existir
        if (! File::exists(storage_path('app/public/partners'))) {
            File::makeDirectory(storage_path('app/public/partners'), 0755, true);
        }

        // Copiar arquivo se existir
        if (File::exists($sourcePath)) {
            File::copy($sourcePath, $destPath);
            $this->command->info('  → Imagem de parceiro copiada para storage');
        } else {
            $this->command->warn('  ⚠ Imagem padrão não encontrada em: '.$sourcePath);
        }
    }
}
