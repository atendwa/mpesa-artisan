<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class MpesaCallbackRequest extends FormRequest
{
    /**
     * @var Collection The parsed response as a Collection
     */
    protected Collection $response;

    /**
     * Fetches the response, parsing it if necessary
     *
     * @return Collection The parsed response
     */
    public function fetchResponse(): Collection
    {
        return $this->response ?? $this->parse();
    }

    /**
     * Checks if the callback was successful based on the ResultCode
     *
     * @return bool True if the callback was successful, false otherwise
     */
    public function successful(): bool
    {
        $this->response = $this->fetchResponse();

        $code = $this->response->get('resultCode');

        return orCheck($code === 0, $code === '0');
    }

    /**
     * Logs the response
     */
    public function log(): void
    {
        Log::info($this->fetchResponse());
    }

    /**
     * Parses the response into a Collection
     *
     * @return Collection The parsed response
     */
    private function parse(): Collection
    {
        $response = (array) json_decode($this->getContent(), true);

        $response = match (array_key_exists('Body', $response)) {
            true => $response['Body']['stkCallback'],
            default => $response,
        };

        $response = match (array_key_exists('Result', $response)) {
            true => $response['Result'],
            default => $response,
        };

        return format_response_keys(collect($response));
    }
}
