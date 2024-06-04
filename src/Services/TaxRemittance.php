<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\Amount;
use Atendwa\MpesaArtisan\Concerns\Utilities\CallbackUrl;
use Atendwa\MpesaArtisan\Concerns\Utilities\Initiator;
use Atendwa\MpesaArtisan\Concerns\Utilities\PartyA;
use Atendwa\MpesaArtisan\Concerns\Utilities\PartyB;
use Atendwa\MpesaArtisan\Concerns\Utilities\Reference;
use Atendwa\MpesaArtisan\Concerns\Utilities\Remarks;
use Atendwa\MpesaArtisan\Concerns\Utilities\TimeoutUrl;
use Throwable;

class TaxRemittance
{
    use Amount, API, CallbackUrl, Initiator, PartyA;
    use PartyB, Reference, Remarks, TimeoutUrl;

    protected array $required = [
        'AccountReference', 'QueueTimeOutURL', 'ResultURL', 'CommandID',
        'RecieverIdentifierType', 'Initiator', 'SenderIdentifierType',
        'Remarks', 'Amount', 'PartyA', 'PartyB',
    ];

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.tax_remittance'));
    }

    /**
     * @throws Throwable
     */
    protected function preload(): void
    {
        $this->defaultRemark('Tax Remittance');
        $this->defaultCallbackUrl();
        $this->securityCredential();
        $this->defaultTimeoutUrl();
        $this->defaultInitiator();
    }

    protected function fillPayload(): void
    {
        $this->payload->push(['AccountReference' => $this->reference]);
        $this->payload->push(['QueueTimeOutURL' => $this->timeoutUrl]);
        $this->payload->push(['ResultURL' => $this->callbackUrl]);
        $this->payload->push(['RecieverIdentifierType' => '4']);
        $this->payload->push(['Initiator' => $this->initiator]);
        $this->payload->push(['SenderIdentifierType' => '4']);
        $this->payload->push(['CommandID' => 'PayTaxToKRA']);
        $this->payload->push(['Remarks' => $this->remarks]);
        $this->payload->push(['Amount' => $this->amount]);
        $this->payload->push(['PartyA' => $this->partyA]);
        $this->payload->push(['PartyB' => $this->partyB]);
    }
}
