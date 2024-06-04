<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait Initiator
{
    protected string $initiator = '';

    public function initiator(string $value): self
    {
        $this->initiator = $value;

        return $this;
    }

    protected function defaultInitiator(): void
    {
        validate_driver($this->driver);
        $default = $this->driver['initiator_name'];

        $value = $this->initiator;
        $value = tannery(filled($value), $value, $default);
        $this->initiator = force_string($value);
    }
}
