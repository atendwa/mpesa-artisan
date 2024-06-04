<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait PhoneNumber
{
    protected string $phoneNumber = '';

    public function phoneNumber(string $value): self
    {
        $this->phoneNumber = $value;

        return $this;
    }
}
