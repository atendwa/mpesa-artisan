<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Support;

use Illuminate\Support\Collection;

class ParseResponse
{
    private Collection $response;

    public function index(Collection $response): Collection
    {
        $this->response = format_response_keys($response);
        $this->checkErrors();

        $this->checkStatus('responseCode', 'successfulResponse');
        $this->checkStatus('resultCode', 'successfulResult');
        $this->assertSuccess();

        $description = $this->response->get('responseDescription') ?? '';
        $customerMessage = $this->response->get('customerMessage') ?? '';
        match ($description === $customerMessage) {
            true => $this->response->forget('customerMessage'),
            default => null,
        };

        return $this->response;
    }

    private function checkErrors(): void
    {
        $hasErrors = $this->response->has('errorMessage');
        $this->response->put('hasErrors', $hasErrors);

        match ($hasErrors) {
            true => $this->queryDirectory(),
            default => null,
        };
    }

    private function queryDirectory(): void
    {
        $code = force_string($this->response->get('errorCode'));
        $this->response->put('errorDefinition', query_directory($code));
    }

    private function checkStatus(string $key, string $statusKey): void
    {
        $code = force_string($this->response->get($key));

        match (blank($code)) {
            true => null,
            default => $this->addStatus($code, $key, $statusKey),
        };
    }

    private function assertSuccess(): void
    {
        $noErrors = ! $this->response->get('hasErrors');
        $response = $this->response->get('successfulResponse');
        $result = $this->response->get('successfulResult');

        $success = andCheck($noErrors, boolval($response));
        $success = andCheck($success, boolval($result));

        $this->response->put('absoluteSuccess', $success);
    }

    private function addStatus(
        string $code,
        string $key,
        string $statusKey
    ): void {
        $this->response->put($key, reduce_character($code));
        $this->response->put($statusKey, $code === '0');
    }
}
