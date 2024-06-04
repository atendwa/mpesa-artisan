<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\ShortCode;
use Throwable;

class STKQuery
{
    use API, ShortCode;

    protected array $required = [
        'CheckoutRequestID', 'BusinessShortCode', 'Password', 'Timestamp',
    ];

    protected string $checkoutRequestID = '';

    public function checkoutRequestID(string $value): self
    {
        $this->checkoutRequestID = $value;

        return $this;
    }

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.stk_query'));
    }

    /**
     * @throws Throwable
     */
    protected function preload(): void
    {
        $this->defaultShortCode();
        $this->timestamp();
        $this->password();
    }

    protected function fillPayload(): void
    {
        $this->payload->push(['CheckoutRequestID' => $this->checkoutRequestID]);
        $this->payload->push(['BusinessShortCode' => $this->shortCode]);
    }
}
