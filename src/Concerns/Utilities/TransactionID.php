<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait TransactionID
{
    protected string $transactionID = '';

    public function transactionID(string $value): self
    {
        $this->transactionID = $value;

        return $this;
    }
}
