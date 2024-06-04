<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\Amount;
use Atendwa\MpesaArtisan\Concerns\Utilities\CallbackUrl;
use Atendwa\MpesaArtisan\Concerns\Utilities\Initiator;
use Atendwa\MpesaArtisan\Concerns\Utilities\Occasion;
use Atendwa\MpesaArtisan\Concerns\Utilities\Remarks;
use Atendwa\MpesaArtisan\Concerns\Utilities\ShortCode;
use Atendwa\MpesaArtisan\Concerns\Utilities\TimeoutUrl;
use Atendwa\MpesaArtisan\Concerns\Utilities\TransactionID;
use Throwable;

class Reversal
{
    use Amount, API, CallbackUrl, Initiator, TransactionID;
    use Occasion, Remarks, ShortCode, TimeoutUrl;

    protected array $required = [
        'TransactionID', 'ReceiverParty', 'QueueTimeOutURL', 'CommandID',
        'ResultURL', 'RecieverIdentifierType', 'Initiator',
        'Occasion', 'Remarks', 'Amount',
    ];

    protected string $receiverParty = '';

    public function receiverParty(string $value): self
    {
        $this->receiverParty = $value;

        return $this;
    }

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.reversal'));
    }

    /**
     * @throws Throwable
     */
    protected function preload(): void
    {
        $default = 'Transaction reversal request.';
        $this->defaultOccasion($default);
        $this->defaultRemark($default);
        $this->defaultCallbackUrl();
        $this->securityCredential();
        $this->defaultTimeoutUrl();
        $this->defaultInitiator();
    }

    protected function fillPayload(): void
    {
        $this->payload->push(['TransactionID' => $this->transactionID]);
        $this->payload->push(['ReceiverParty' => $this->receiverParty]);
        $this->payload->push(['QueueTimeOutURL' => $this->timeoutUrl]);
        $this->payload->push(['CommandID' => 'TransactionReversal']);
        $this->payload->push(['ResultURL' => $this->callbackUrl]);
        $this->payload->push(['RecieverIdentifierType' => '11']);
        $this->payload->push(['Initiator' => $this->initiator]);
        $this->payload->push(['Occasion' => $this->occasion]);
        $this->payload->push(['Remarks' => $this->remarks]);
        $this->payload->push(['Amount' => $this->amount]);
    }
}
