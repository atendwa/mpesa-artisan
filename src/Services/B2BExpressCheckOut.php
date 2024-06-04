<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\Amount;
use Atendwa\MpesaArtisan\Concerns\Utilities\CallbackUrl;
use Atendwa\MpesaArtisan\Concerns\Utilities\Reference;

class B2BExpressCheckOut
{
    use Amount, API, CallbackUrl, Reference;

    protected string $primaryShortCode = '';

    protected string $receiverShortCode = '';

    protected string $requestRefID = '';

    protected string $partnerName = '';

    protected array $required = [
        'primaryShortCode', 'receiverShortCode', 'requestRefID',
        'paymentRef', 'callbackUrl', 'partnerName', 'amount',
    ];

    public function primaryShortCode(string $value): self
    {
        $this->primaryShortCode = $value;

        return $this;
    }

    public function partnerName(string $value): self
    {
        $this->partnerName = $value;

        return $this;
    }

    public function receiverShortCode(string $value): self
    {
        $this->receiverShortCode = $value;

        return $this;
    }

    public function requestRefID(string $value): self
    {
        $this->requestRefID = $value;

        return $this;
    }

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.b2b_express_checkout'));
    }

    protected function preload(): void
    {
        $this->defaultCallbackUrl();
    }

    protected function fillPayload(): void
    {
        $this->payload->push(['receiverShortCode' => $this->receiverShortCode]);
        $this->payload->push(['primaryShortCode' => $this->primaryShortCode]);
        $this->payload->push(['RequestRefID' => $this->requestRefID]);
        $this->payload->push(['callbackUrl' => $this->callbackUrl]);
        $this->payload->push(['partnerName' => $this->partnerName]);
        $this->payload->push(['paymentRef' => $this->reference]);
        $this->payload->push(['amount' => $this->amount]);
    }
}
