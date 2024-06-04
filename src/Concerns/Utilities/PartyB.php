<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait PartyB
{
    protected string $partyB = '';

    public function partyB(string $value): self
    {
        $this->partyB = $value;

        return $this;
    }
}
