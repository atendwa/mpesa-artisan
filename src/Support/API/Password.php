<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Support\API;

use Atendwa\MpesaArtisan\Concerns\Core\Driver;
use Throwable;

class Password
{
    use Driver;

    /**
     * @throws Throwable
     */
    public function generate(): string
    {
        validate_driver($this->driver);

        $shortcode = $this->fetchShortcode();
        $key = $this->driver['passkey'];

        return base64_encode($shortcode . $key . fetch_timestamp());
    }

    /**
     * @return string The fetched shortcode
     */
    private function fetchShortcode(): string
    {
        return match ($this->useConsumerKeyPair) {
            true => $this->driver['shortcodes']['business'],
            default => $this->driver['shortcodes']['payment'],
        };
    }
}
