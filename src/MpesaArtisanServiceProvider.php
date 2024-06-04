<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan;

use Atendwa\MpesaArtisan\Commands\InstallMpesaArtisan;
use Atendwa\MpesaArtisan\Core\IPWhitelist;
use Atendwa\MpesaArtisan\Core\ValidateDriver;
use Atendwa\MpesaArtisan\Http\Middleware\AllowWhitelistedMpesaIps;
use Atendwa\MpesaArtisan\Support\ParseResponse;
use Atendwa\MpesaArtisan\Support\SanitisePhoneNumber;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MpesaArtisanServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        app(Router::class)->aliasMiddleware(
            'mpesa-whitelist',
            AllowWhitelistedMpesaIps::class
        );

        Route::macro('callback', function ($uri, $action) {
            return Route::post($uri, $action)
                ->middleware('mpesa-whitelist')
                ->withoutMiddleware([VerifyCsrfToken::class]);
        });

        match ($this->app->runningInConsole()) {
            true => $this->registerConsoleAssets(),
            default => null,
        };
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $directoryPath = __DIR__ . '/../config/directory.php';
        $this->mergeConfigFrom($directoryPath, 'directory');
        $this->mergeConfigFrom(__DIR__ . '/../config/mpesa.php', 'mpesa');

        app()->singleton(
            SanitisePhoneNumber::class,
            fn () => new SanitisePhoneNumber()
        );

        app()->singleton(ValidateDriver::class, fn () => new ValidateDriver());
        app()->singleton(ParseResponse::class, fn () => new ParseResponse());
        app()->singleton(IPWhitelist::class, fn () => new IPWhitelist());

        $loader = AliasLoader::getInstance();
        $loader->alias('Daraja', 'Atendwa\MpesaArtisan\Facades\Daraja');
    }

    private function registerConsoleAssets(): void
    {
        $this->commands(InstallMpesaArtisan::class);

        $directoryPath = config_path('directory.php');
        $mpesaPath = config_path('mpesa.php');
        $this->publishes([
            __DIR__ . '/../config/directory.php' => $directoryPath,
            __DIR__ . '/../config/mpesa.php' => $mpesaPath,
        ], 'config');

        //        $databasePath = database_path('migrations');
        //        $this->publishes([
        //            __DIR__ . '/../database/migrations' => $databasePath,
        //        ], 'migrations');
    }
}
