<?php

namespace App\Console\Commands;

use App\Services\TestimonialService;
use Illuminate\Console\Command;

class CleanupTestimonialImages extends Command
{
    protected $signature = 'testimonials:cleanup-images';

    protected $description = 'Remove imagens de depoimentos deletados (soft deleted)';

    public function handle(TestimonialService $testimonialService)
    {
        $this->info('Iniciando limpeza de imagens de depoimentos...');

        try {
            $count = $testimonialService->cleanupDeletedTestimonialsImages();
            $this->info("✓ {$count} imagens removidas com sucesso!");

            return 0;
        } catch (\Throwable $e) {
            $this->error("✗ Erro ao limpar imagens: {$e->getMessage()}");

            return 1;
        }
    }
}
