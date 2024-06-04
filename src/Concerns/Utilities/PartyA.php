<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait PartyA
{
    protected string $partyA = '';

    public function partyA(string $value): self
    {
        $this->partyA = $value;

        return $this;
    }
}
