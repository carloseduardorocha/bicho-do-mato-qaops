<?php

namespace App\Console\Commands;

use App\Services\PartnerService;
use Illuminate\Console\Command;

class CleanupPartnerImages extends Command
{
    protected $signature = 'partners:cleanup-images';
    protected $description = 'Remove imagens de parceiros deletados (soft deleted)';

    public function handle(PartnerService $partnerService)
    {
        $this->info('Iniciando limpeza de imagens...');
        
        try {
            $count = $partnerService->cleanupDeletedPartnersImages();
            $this->info("✓ {$count} imagens removidas com sucesso!");
            return 0;
        } catch (\Throwable $e) {
            $this->error("✗ Erro ao limpar imagens: {$e->getMessage()}");
            return 1;
        }
    }
}
