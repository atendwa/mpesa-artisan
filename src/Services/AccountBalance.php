<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\CallbackUrl;
use Atendwa\MpesaArtisan\Concerns\Utilities\IdentifierType;
use Atendwa\MpesaArtisan\Concerns\Utilities\Initiator;
use Atendwa\MpesaArtisan\Concerns\Utilities\PartyA;
use Atendwa\MpesaArtisan\Concerns\Utilities\Remarks;
use Atendwa\MpesaArtisan\Concerns\Utilities\TimeoutUrl;
use Throwable;

class AccountBalance
{
    use API, CallbackUrl, IdentifierType, Initiator;
    use PartyA, Remarks, TimeoutUrl;

    protected array $required = [
        'SecurityCredential', 'Initiator', 'ResultURL', 'CommandID',
        'IdentifierType', 'Remarks', 'QueueTimeOutURL', 'PartyA',
    ];

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.account_balance'));
    }

    /**
     * @throws Throwable
     */
    protected function preload(): void
    {
        $this->payload->push(['CommandID' => 'AccountBalance']);
        $this->defaultRemark('Get account balance.');
        $this->defaultCallbackUrl();
        $this->securityCredential();
        $this->defaultTimeoutUrl();
        $this->defaultInitiator();
    }

    protected function fillPayload(): void
    {
        $this->payload->push(['IdentifierType' => $this->identifierType]);
        $this->payload->push(['QueueTimeOutURL' => $this->timeoutUrl]);
        $this->payload->push(['ResultURL' => $this->callbackUrl]);
        $this->payload->push(['Initiator' => $this->initiator]);
        $this->payload->push(['Remarks' => $this->remarks]);
        $this->payload->push(['PartyA' => $this->partyA]);
    }
}
