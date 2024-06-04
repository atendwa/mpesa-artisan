<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Core;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class IPWhitelist
{
    public function enabled(): bool
    {
        return boolval(config('mpesa.configuration.use_whitelist'));
    }

    public function disabled(): bool
    {
        return ! $this->enabled();
    }

    /**
     * @param  string  $ip  The IP address to check.
     */
    public function allows(string $ip): bool
    {
        return $this->whitelist()->contains($ip);
    }

    public function block(): JsonResponse
    {
        return response()->json(['message' => 'Unauthorized IP Address'], 403);
    }

    /**
     * @return Collection A collection of whitelisted IP addresses.
     */
    private function whitelist(): Collection
    {
        $whitelistedIps = config('mpesa.whitelisted_ips');

        return match (is_array($whitelistedIps)) {
            true => collect($whitelistedIps),
            default => collect(),
        };
    }
}
