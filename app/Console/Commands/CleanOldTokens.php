<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;

class CleanOldTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina tokens de Sanctum no usados en 7 días';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = PersonalAccessToken::where(
            'last_used_at',
            '<',
            now()->subMinutes(1)
        )->delete();

        $this->info("Tokens eliminados: {$deleted}");
        return Command::SUCCESS;
    }
}
