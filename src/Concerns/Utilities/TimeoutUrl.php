<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait TimeoutUrl
{
    protected string $timeoutUrl = '';

    public function timeoutUrl(string $value): self
    {
        $this->timeoutUrl = $value;

        return $this;
    }

    protected function defaultTimeoutUrl(): void
    {
        validate_driver($this->driver);
        $default = $this->driver['callbacks']['default_timeout_url'];

        $value = $this->timeoutUrl;
        $value = tannery(filled($value), $value, $default);
        $this->timeoutUrl = force_string($value);
    }
}
