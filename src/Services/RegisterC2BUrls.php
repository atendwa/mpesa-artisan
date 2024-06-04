<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\API;
use Atendwa\MpesaArtisan\Concerns\Utilities\ShortCode;

class RegisterC2BUrls
{
    use API, ShortCode;

    protected array $required = [
        'ShortCode', 'ResponseType', 'ConfirmationURL', 'ValidationURL',
    ];

    private string $responseType = 'Completed';

    private string $confirmationURL = '';

    private string $validationURL = '';

    public function completed(): self
    {
        $this->responseType = 'Completed';

        return $this;
    }

    public function cancelled(): self
    {
        $this->responseType = 'Cancelled';

        return $this;
    }

    public function confirmationUrl(string $value): self
    {
        $this->confirmationURL = $value;

        return $this;
    }

    public function validationUrl(string $value): self
    {
        $this->validationURL = $value;

        return $this;
    }

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.c2b_register_url'));
    }

    protected function preload(): void
    {
        $this->defaultShortCode();
    }

    protected function fillPayload(): void
    {
        $this->payload->push(['ConfirmationURL' => $this->confirmationURL]);
        $this->payload->push(['ValidationURL' => $this->validationURL]);
        $this->payload->push(['ResponseType' => $this->responseType]);
        $this->payload->push(['ShortCode' => $this->shortCode]);
    }
}
