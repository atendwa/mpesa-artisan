<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Core;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Throwable;

trait Driver
{
    protected string $driverKey = 'default';

    protected array $driver;

    /**
     * Indicates whether to use the consumer or payment key pair.
     */
    protected bool $useConsumerKeyPair = true;

    /**
     * Set the driver key and load the corresponding driver configuration.
     *
     * @param  string  $value  The value of the driver key.
     *
     * @throws Throwable
     */
    public function driver(string $value): self
    {
        $this->driverKey = $value;
        $this->loadDriver();

        return $this;
    }

    /**
     * Set the flag to use the consumer or payment key pair.
     *
     * @param  bool  $value  The value to set for using the consumer key pair
     */
    public function useConsumerKeyPair(bool $value): self
    {
        $this->useConsumerKeyPair = $value;
        Cache::forget(access_token_key());

        return $this;
    }

    /**
     * Load the driver configuration based on the current driver key.
     *
     * @throws Throwable
     */
    protected function loadDriver(): void
    {
        $this->loadDriverName();
        $this->checkDriver();

        $this->driver = Config::get('mpesa.drivers.' . $this->driverKey);
    }

    /**
     * Load the driver name
     */
    private function loadDriverName(): void
    {
        match (blank($this->driverKey)) {
            true => $this->loadDefaultDriverName(),
            default => null,
        };
    }

    /**
     * Load the default driver name if the current driver key is blank.
     */
    private function loadDefaultDriverName(): void
    {
        $this->driverKey = default_mpesa_driver();
    }

    /**
     * Check if the specified driver exists in the configuration.
     *
     * @throws Throwable
     */
    private function checkDriver(): void
    {
        $exists = Config::has('mpesa.drivers.' . $this->driverKey);
        throw_if(! $exists, new Exception('Driver not found!'));
    }
}
