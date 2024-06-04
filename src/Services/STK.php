<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\Amount;
use Atendwa\MpesaArtisan\Concerns\Utilities\CallbackUrl;
use Atendwa\MpesaArtisan\Concerns\Utilities\PartyB;
use Atendwa\MpesaArtisan\Concerns\Utilities\PhoneNumber;
use Atendwa\MpesaArtisan\Concerns\Utilities\Reference;
use Atendwa\MpesaArtisan\Concerns\Utilities\ShortCode;
use Throwable;

class STK
{
    use Amount,API, CallbackUrl,PartyB,PhoneNumber,Reference,ShortCode;

    protected array $required = [
        'BusinessShortCode', 'Password', 'Timestamp', 'TransactionType',
        'CallBackURL', 'AccountReference', 'TransactionDesc',
        'Amount', 'PartyA', 'PartyB', 'PhoneNumber',
    ];

    protected string $transactionType = 'CustomerPayBillOnline';

    protected string $description = '';

    public function description(string $value): self
    {
        $this->description = $value;

        return $this;
    }

    public function payBill(): self
    {
        $this->transactionType = 'CustomerPayBillOnline';

        return $this;
    }

    public function buyGoods(): self
    {
        $this->transactionType = 'CustomerBuyGoodsOnline';

        return $this;
    }

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.mpesa_express'));
    }

    /**
     * @throws Throwable
     */
    protected function preload(): void
    {
        $this->defaultCallbackUrl();
        $this->defaultShortCode();
        $this->timestamp();
        $this->password();
    }

    protected function fillPayload(): void
    {
        $this->payload->push(['TransactionType' => $this->transactionType]);
        $this->payload->push(['BusinessShortCode' => $this->shortCode]);
        $this->payload->push(['TransactionDesc' => $this->description]);
        $this->payload->push(['AccountReference' => $this->reference]);
        $this->payload->push(['CallBackURL' => $this->callbackUrl]);
        $this->payload->push(['PhoneNumber' => $this->phoneNumber]);
        $this->payload->push(['PartyA' => $this->phoneNumber]);
        $this->payload->push(['Amount' => $this->amount]);
        $this->payload->push(['PartyB' => $this->partyB]);
    }
}
