<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait ShortCode
{
    protected string $shortCode = '';

    public function shortCode(string $value): self
    {
        $this->shortCode = $value;

        return $this;
    }

    protected function defaultShortCode(): void
    {
        $check = $this->useConsumerKeyPair;

        $this->shortCode = match (filled($this->shortCode)) {
            default => default_short_code($check, $this->driver),
            true => $this->shortCode,
        };
    }
}
