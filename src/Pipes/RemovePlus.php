<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Pipes;

use Closure;
use Illuminate\Support\Str;

class RemovePlus
{
    /**
     * Remove the plus sign from the beginning of the phone number, if present.
     *
     * @param  string  $phoneNumber  The phone number to process
     * @param  Closure  $next  The next closure in the pipeline
     *
     * @return string The processed phone number
     */
    public function handle(string $phoneNumber, Closure $next): string
    {
        $check = Str::startsWith($phoneNumber, '+');

        $phoneNumber = match ($check) {
            true => str_replace('+', '', $phoneNumber),
            default => $phoneNumber,
        };

        return $next($phoneNumber);
    }
}
