<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\CallbackUrl;
use Atendwa\MpesaArtisan\Concerns\Utilities\IdentifierType;
use Atendwa\MpesaArtisan\Concerns\Utilities\Initiator;
use Atendwa\MpesaArtisan\Concerns\Utilities\Occasion;
use Atendwa\MpesaArtisan\Concerns\Utilities\PartyA;
use Atendwa\MpesaArtisan\Concerns\Utilities\Remarks;
use Atendwa\MpesaArtisan\Concerns\Utilities\TimeoutUrl;
use Atendwa\MpesaArtisan\Concerns\Utilities\TransactionID;
use Throwable;

class TransactionStatus
{
    use API,CallbackUrl,Occasion,PartyA, TransactionID;
    use IdentifierType,Initiator,Remarks,TimeoutUrl;

    protected array $required = [
        'Initiator', 'SecurityCredential', 'CommandID', 'PartyA', 'Remarks',
        'IdentifierType', 'ResultURL', 'QueueTimeOutURL', 'Occasion',
    ];

    private string $originatorConversationID = '';

    public function originatorConversationID(string $value): self
    {
        $this->originatorConversationID = $value;

        return $this;
    }

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.transaction_status'));
    }

    /**
     * @throws Throwable
     */
    protected function preload(): void
    {
        $default = 'Transaction status request.';
        $this->defaultOccasion($default);
        $this->defaultRemark($default);
        $this->defaultCallbackUrl();
        $this->securityCredential();
        $this->defaultTimeoutUrl();
        $this->defaultInitiator();
    }

    protected function fillPayload(): void
    {
        $value = $this->originatorConversationID;
        $this->payload->push(['OriginatorConversationID' => $value]);
        $this->payload->push(['CommandID' => 'TransactionStatusQuery']);
        $this->payload->push(['TransactionID' => $this->transactionID]);
        $this->payload->push(['QueueTimeOutURL' => $this->timeoutUrl]);
        $this->payload->push(['ResultURL' => $this->callbackUrl]);
        $this->payload->push(['Initiator' => $this->initiator]);
        $this->payload->push(['Occasion' => $this->occasion]);
        $this->payload->push(['Remarks' => $this->remarks]);
        $this->payload->push(['PartyA' => $this->partyA]);
        $this->payload->push(['IdentifierType' => '4']);
    }
}
