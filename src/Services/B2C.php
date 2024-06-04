<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\Amount;
use Atendwa\MpesaArtisan\Concerns\Utilities\CallbackUrl;
use Atendwa\MpesaArtisan\Concerns\Utilities\Initiator;
use Atendwa\MpesaArtisan\Concerns\Utilities\Occasion;
use Atendwa\MpesaArtisan\Concerns\Utilities\PartyA;
use Atendwa\MpesaArtisan\Concerns\Utilities\PartyB;
use Atendwa\MpesaArtisan\Concerns\Utilities\Remarks;
use Atendwa\MpesaArtisan\Concerns\Utilities\ShortCode;
use Atendwa\MpesaArtisan\Concerns\Utilities\TimeoutUrl;
use Throwable;

class B2C
{
    use Amount,API,CallbackUrl,Initiator,Occasion,PartyA;
    use PartyB,Remarks,ShortCode,TimeoutUrl;

    protected array $required = [
        'QueueTimeOutURL', 'InitiatorName', 'ResultURL', 'Occassion',
        'Remarks', 'CommandID', 'Amount', 'PartyA', 'PartyB',
    ];

    private string $type = 'BusinessPayment';

    public function businessPayment(): self
    {
        $this->type = 'BusinessPayment';

        return $this;
    }

    public function promotionPayment(): self
    {
        $this->type = 'PromotionPayment';

        return $this;
    }

    public function salaryPayment(): self
    {
        $this->type = 'SalaryPayment';

        return $this;
    }

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.b2c'));
    }

    /**
     * @throws Throwable
     */
    protected function preload(): void
    {
        $this->useConsumerKeyPair = false;
        $this->securityCredential();
        $this->defaultCallbackUrl();
        $this->defaultTimeoutUrl();
        $this->defaultInitiator();
        $this->defaultShortCode();
    }

    protected function fillPayload(): void
    {
        $this->payload->push(['QueueTimeOutURL' => $this->timeoutUrl]);
        $this->payload->push(['InitiatorName' => $this->initiator]);
        $this->payload->push(['ResultURL' => $this->callbackUrl]);
        $this->payload->push(['Occassion' => $this->occasion]);
        $this->payload->push(['Remarks' => $this->remarks]);
        $this->payload->push(['CommandID' => $this->type]);
        $this->payload->push(['Amount' => $this->amount]);
        $this->payload->push(['PartyA' => $this->partyA]);
        $this->payload->push(['PartyB' => $this->partyB]);
    }
}
