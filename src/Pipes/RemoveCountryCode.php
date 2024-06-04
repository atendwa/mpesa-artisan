<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Pipes;

use Closure;
use Illuminate\Support\Str;

class RemoveCountryCode
{
    /**
     * Remove the country code from the phone number if it starts with '254'
     *
     * @param  string  $phoneNumber  The phone number to process
     * @param  Closure  $next  The next closure in the pipeline
     *
     * @return string The processed phone number
     */
    public function handle(string $phoneNumber, Closure $next): string
    {
        $check = Str::startsWith($phoneNumber, '254');

        $phoneNumber = match ($check) {
            true => str_replace('254', '', $phoneNumber),
            default => $phoneNumber,
        };

        return $next($phoneNumber);
    }
}
