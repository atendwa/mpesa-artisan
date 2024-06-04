<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Commands;

use Illuminate\Console\Command;

class InstallMpesaArtisan extends Command
{
    protected $signature = 'mpesa-artisan:install';

    protected $description = 'Published Mpesa Artisan package assets.';

    public function handle(): void
    {
        info('Installing mpesa-artisan...');

        $param = [
            '--provider' => "Atendwa\MpesaArtisan\MpesaArtisanServiceProvider",
            '--force' => 'true',
        ];

        $tag = ['--tag' => 'config'];
        $this->call('vendor:publish', array_merge($param, $tag));

        $tag = ['--tag' => 'migrations'];
        $this->call('vendor:publish', array_merge($param, $tag));

        $this->info('Mpesa Artisan is ready to go. Happy coding!');
    }
}
