<?php

namespace Atendwa\MpesaArtisan\Tests;

use Atendwa\MpesaArtisan\MpesaArtisanServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function getEnvironmentSetUp($app): void
    {
    }

    protected function getPackageProviders($app): array
    {
        return [
            MpesaArtisanServiceProvider::class,
        ];
    }
}
