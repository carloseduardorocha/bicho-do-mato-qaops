<?php

namespace App\Console\Commands;

use App\Services\NewsService;
use Illuminate\Console\Command;

class CleanupNewsImages extends Command
{
    protected $signature = 'news:cleanup-images';

    protected $description = 'Remove imagens de notícias deletadas (soft deleted)';

    public function handle(NewsService $newsService)
    {
        $this->info('Iniciando limpeza de imagens de notícias...');

        try {
            $count = $newsService->cleanupDeletedNewsImages();
            $this->info("✓ {$count} imagens removidas com sucesso!");

            return 0;
        } catch (\Throwable $e) {
            $this->error("✗ Erro ao limpar imagens: {$e->getMessage()}");

            return 1;
        }
    }
}
