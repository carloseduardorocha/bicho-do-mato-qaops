<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Limpeza de imagens de parceiros
        $schedule->command('partners:cleanup-images')
            ->weekly()
            ->sundays()
            ->at('03:00');

        // Limpeza de imagens de depoimentos
        $schedule->command('testimonials:cleanup-images')
            ->weekly()
            ->sundays()
            ->at('03:15');

        // Limpeza de imagens de notícias
        $schedule->command('news:cleanup-images')
            ->weekly()
            ->sundays()
            ->at('03:30');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
