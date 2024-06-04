<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Core\Driver;
use Atendwa\MpesaArtisan\Support\API\Credentials;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class AccessToken
{
    use Driver;

    /**
     * Initiates the process to generate an access token.
     *
     * @return string The generated access token.
     *
     * @throws Throwable If an error occurs during the process.
     */
    public function generate(): string
    {
        return match ((bool) config('mpesa.cache.enabled')) {
            true => $this->fetchTokenFromCache(),
            default => $this->fetchToken(),
        };
    }

    /**
     * Fetches the access token directly from the API.
     *
     * @return string The fetched access token.
     *
     * @throws ConnectionException
     * @throws Throwable
     */
    private function fetchToken(): string
    {
        $credentials = (new Credentials())->driver($this->driverKey)
            ->useConsumerKeyPair($this->useConsumerKeyPair);

        [$key, $secret] = $credentials->generate();

        return force_string(Http::withBasicAuth($key, $secret)
            ->baseUrl(fetch_base_url())
            ->get(force_string(config('mpesa.endpoints.access_token')))
            ->collect()
            ->get('access_token'));
    }

    /**
     * Fetches the access token from cache.
     *
     * @return string The fetched access token.
     */
    private function fetchTokenFromCache(): string
    {
        $key = access_token_key();

        return Cache::remember($key, 50, fn () => $this->fetchToken());
    }
}
