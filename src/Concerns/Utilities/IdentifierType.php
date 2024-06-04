<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait IdentifierType
{
    protected string $identifierType = '4';

    /**
     * Sets the identifier type to '1' for MSISDN (mobile number).
     */
    public function msisdn(): self
    {
        $this->identifierType = '1';

        return $this;
    }

    /**
     * Sets the identifier type to '2' for till number.
     */
    public function tillNumber(): self
    {
        $this->identifierType = '2';

        return $this;
    }

    /**
     * Sets the identifier type to '4' for organisation short code.
     */
    public function organisationShortCode(): self
    {
        $this->identifierType = '4';

        return $this;
    }
}
