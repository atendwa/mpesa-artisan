<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Pipes;

use Closure;
use Exception;
use Throwable;

class ValidatePhoneNumber
{
    /**
     * Validate the format of the phone number.
     *
     * @param  string  $phoneNumber  The phone number to validate
     * @param  Closure  $next  The next closure in the pipeline
     *
     * @throws Throwable
     */
    public function handle(string $phoneNumber, Closure $next): string
    {
        $message = 'Invalid Phone Number Provided.';

        throw_if(mb_strlen($phoneNumber) !== 9, new Exception($message));

        return $next($phoneNumber);
    }
}
