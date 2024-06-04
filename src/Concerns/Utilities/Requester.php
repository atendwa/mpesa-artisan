<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait Requester
{
    protected string $requester = '';

    public function requester(string $value): self
    {
        $this->requester = $value;

        return $this;
    }
}
