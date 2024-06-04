<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Core;

use Atendwa\MpesaArtisan\Core\DarajaClient;
use Atendwa\MpesaArtisan\Support\API\Password;
use Atendwa\MpesaArtisan\Support\API\SecurityCredential;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;

trait API
{
    use Driver;

    protected string $base = ' field is required.';

    protected DarajaClient $darajaClient;

    protected Collection $payload;

    protected string $endpoint;

    /**
     * Prepares necessary assets & sends a request to the endpoint.
     *
     * @return Collection containing the response data specified
     *
     * @throws ConnectionException if a connection error occurs.
     * @throws Throwable in case of other errors.
     */
    public function post(): Collection
    {
        $this->darajaClient = new DarajaClient();
        $this->payload = collect();
        $this->loadDriver();

        $this->preload();
        $this->fillPayload();
        $this->validatePayload($this->required);

        return $this->postRequest();
    }

    abstract protected function endpoint(): string;

    abstract protected function preload(): void;

    abstract protected function fillPayload(): void;

    /**
     * Generates and adds the password to the payload.
     *
     * @throws Throwable
     */
    protected function password(): void
    {
        $password = (new Password())->driver($this->driverKey)
            ->useConsumerKeyPair($this->useConsumerKeyPair);

        $this->payload->push(['Password' => $password->generate()]);
    }

    protected function timestamp(): void
    {
        $this->payload->push(['Timestamp' => fetch_timestamp()]);
    }

    /**
     * Sends the request to the Mpesa API endpoint using the loaded payload.
     *
     * @return Collection containing the response data.
     *
     * @throws Throwable if an error occurs during the request.
     * @throws ConnectionException if a connection error occurs.
     */
    protected function postRequest(): Collection
    {
        return $this->darajaClient->driver($this->driverKey)
            ->payload($this->payload->collapse()->toArray())
            ->useConsumerKeyPair($this->useConsumerKeyPair)
            ->endpoint($this->endpoint())
            ->initiate();
    }

    /**
     * Generates and adds the security credential to the payload.
     *
     * @throws Throwable
     */
    protected function securityCredential(): void
    {
        $credential = (new SecurityCredential())->driver($this->driverKey);
        $this->payload->push(['SecurityCredential' => $credential->generate()]);
    }

    protected function validatePayload(array $keys): void
    {
        collect($keys)->each(
            /**
             * @throws Throwable
             */
            function ($key): void {
                $payload = $this->payload->collapse();
                $value = $payload->get($key);
                $key = str_replace('_', ' ', Str::snake($key));

                $message = Str::title($key) . $this->base;
                throw_if(blank($value), new InvalidArgumentException($message));
            }
        );
    }
}
