<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait Amount
{
    protected int $amount = 0;

    public function amount(int $value): self
    {
        $this->amount = $value;

        return $this;
    }
}
