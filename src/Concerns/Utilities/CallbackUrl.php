<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait CallbackUrl
{
    protected string $callbackUrl = '';

    public function callbackUrl(string $value): self
    {
        $this->callbackUrl = $value;

        return $this;
    }

    protected function defaultCallbackUrl(): void
    {
        validate_driver($this->driver);
        $default = $this->driver['callbacks']['default'];

        $value = $this->callbackUrl;
        $value = tannery(filled($value), $value, $default);
        $this->callbackUrl = force_string($value);
    }
}
