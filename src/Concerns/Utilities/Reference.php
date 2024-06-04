<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait Reference
{
    protected string $reference = '';

    public function reference(string $value): self
    {
        $this->reference = $value;

        return $this;
    }
}
