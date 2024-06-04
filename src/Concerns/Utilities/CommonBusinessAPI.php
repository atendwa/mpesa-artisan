<?php

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Throwable;

trait CommonBusinessAPI
{
    use Amount, API, CallbackUrl, Initiator, PartyA, PartyB;
    use PhoneNumber, Reference, Remarks, Requester, TimeoutUrl;

    protected array $required = [
        'AccountReference', 'QueueTimeOutURL', 'ResultURL', 'CommandID',
        'SenderIdentifierType', 'Remarks', 'Amount', 'PartyA', 'PartyB',
        'RecieverIdentifierType', 'Initiator', 'Requester',
    ];

    /**
     * @throws Throwable
     */
    protected function preload(): void
    {
        $this->defaultRemark('Business Payment');
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
        $this->payload->push(['CommandID' => 'BusinessPayBill']);
        $this->payload->push(['RecieverIdentifierType' => '4']);
        $this->payload->push(['Initiator' => $this->initiator]);
        $this->payload->push(['Requester' => $this->requester]);
        $this->payload->push(['SenderIdentifierType' => '4']);
        $this->payload->push(['Remarks' => $this->remarks]);
        $this->payload->push(['Amount' => $this->amount]);
        $this->payload->push(['PartyA' => $this->partyA]);
        $this->payload->push(['PartyB' => $this->partyB]);
    }
}
