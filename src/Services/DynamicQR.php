<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\Amount;
use Atendwa\MpesaArtisan\Concerns\Utilities\Reference;

class DynamicQR
{
    use Amount, API, Reference;

    protected array $required = [
        'RefNo', 'CPI', 'MerchantName', 'Amount', 'Size', 'TrxCode',
    ];

    private string $transactionType = 'BG';

    private string $merchantName = '';

    private int $size = 300;

    private string $creditPartyIdentifier = '';

    public function creditPartyIdentifier(string $value): self
    {
        $this->creditPartyIdentifier = $value;

        return $this;
    }

    public function size(int $value): self
    {
        $this->size = $value;

        return $this;
    }

    public function merchantName(string $value): self
    {
        $this->merchantName = $value;

        return $this;
    }

    public function buyGoods(): self
    {
        $this->transactionType = 'BG';

        return $this;
    }

    public function withdrawFromAgent(): self
    {
        $this->transactionType = 'WA';

        return $this;
    }

    public function paybill(): self
    {
        $this->transactionType = 'PB';

        return $this;
    }

    public function sendMoney(): self
    {
        $this->transactionType = 'SM';

        return $this;
    }

    public function sendToBusiness(): self
    {
        $this->transactionType = 'SB';

        return $this;
    }

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.dynamic_qr'));
    }

    protected function fillPayload(): void
    {
        $this->payload->push(['MerchantName' => $this->merchantName]);
        $this->payload->push(['CPI' => $this->creditPartyIdentifier]);
        $this->payload->push(['TrxCode' => $this->transactionType]);
        $this->payload->push(['RefNo' => $this->reference]);
        $this->payload->push(['Amount' => $this->amount]);
        $this->payload->push(['Size' => $this->size]);
    }

    protected function preload(): void
    {
    }
}
