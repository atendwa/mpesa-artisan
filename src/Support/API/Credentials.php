<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Support\API;

use Atendwa\MpesaArtisan\Concerns\Core\Driver;
use Throwable;

class Credentials
{
    use Driver;

    /**
     * Initiate the process of fetching credentials.
     *
     * @return array<string> The credentials [key, secret]
     *
     * @throws Throwable
     */
    public function generate(): array
    {
        validate_driver($this->driver);

        return [$this->fetchKey(), $this->fetchSecret()];
    }

    /**
     * @throws Throwable
     */
    private function fetchKey(): string
    {
        return match ($this->useConsumerKeyPair) {
            true => $this->driver['key_pairs']['consumer']['key'],
            false => $this->driver['key_pairs']['payment']['key'],
        };
    }

    /**
     * @throws Throwable
     */
    private function fetchSecret(): string
    {
        return match ($this->useConsumerKeyPair) {
            true => $this->driver['key_pairs']['consumer']['secret'],
            false => $this->driver['key_pairs']['payment']['secret'],
        };
    }
}
