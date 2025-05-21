<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearOldPageViews extends Command
{
    protected $signature = 'pageviews:clear-old';
    protected $description = 'Remove registros de page_views com mais de 30 dias';

    public function handle(): void
    {
        $deleted = DB::table('page_views')
            ->where('created_at', '<', now()->subDays(30))
            ->delete();

        $this->info("{$deleted} registros antigos removidos com sucesso.");
    }
}