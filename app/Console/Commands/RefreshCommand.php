<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'app:refresh';

    protected $description = 'Refresh migrations and seeds';
    public function handle(): int
    {
        if(app()->isProduction()) {
            return self::FAILURE;
        }

        Storage::deleteDirectory('products');
        Storage::deleteDirectory('brands');
        Storage::deleteDirectory('categories');

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);

        return self::SUCCESS;
    }
}
