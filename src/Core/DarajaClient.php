<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Core;

use Atendwa\MpesaArtisan\Concerns\Core\Driver;
use Atendwa\MpesaArtisan\Services\AccessToken;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Throwable;

class DarajaClient
{
    use Driver;

    private string $endpoint;

    /**
     * @var array<mixed> The payload data to be sent in the request.
     */
    private array $payload;

    /**
     * Set the endpoint for the API request.
     *
     * @param  string  $endpoint  The API endpoint
     *
     * @return $this
     */
    public function endpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Set the payload for the API request.
     *
     * @param  array<mixed>  $payload  The request payload
     *
     * @return $this
     */
    public function payload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Initiate the API request.
     *
     * @return Collection<mixed> The response from the API
     *
     * @throws ConnectionException
     * @throws Throwable
     */
    public function initiate(): Collection
    {
        return parse_response(Http::withToken($this->fetchToken())
            ->baseUrl(fetch_base_url())
            ->acceptJson()
            ->post($this->endpoint, $this->payload)
            ->collect());
    }

    /**
     * @throws Throwable
     */
    private function fetchToken(): string
    {
        return (new AccessToken())->driver($this->driverKey)
            ->useConsumerKeyPair($this->useConsumerKeyPair)
            ->generate();
    }
}
