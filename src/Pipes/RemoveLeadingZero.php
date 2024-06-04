<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Pipes;

use Closure;

class RemoveLeadingZero
{
    /**
     * Remove the leading zero from the phone number if it starts with '0'
     *
     * @param  string  $phoneNumber  The phone number to process
     * @param  Closure  $next  The next closure in the pipeline
     *
     * @return string The processed phone number
     */
    public function handle(string $phoneNumber, Closure $next): string
    {
        $check = $phoneNumber[0] === '0';

        $phoneNumber = match ($check) {
            true => mb_substr($phoneNumber, 1),
            default => $phoneNumber,
        };

        return $next($phoneNumber);
    }
}
