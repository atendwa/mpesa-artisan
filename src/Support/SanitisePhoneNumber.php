<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Support;

use Atendwa\MpesaArtisan\Pipes\RemoveCountryCode;
use Atendwa\MpesaArtisan\Pipes\RemoveLeadingZero;
use Atendwa\MpesaArtisan\Pipes\RemovePlus;
use Atendwa\MpesaArtisan\Pipes\ValidatePhoneNumber;
use Illuminate\Support\Facades\Pipeline;

class SanitisePhoneNumber
{
    /**
     * Sanitise the phone number through a pipeline.
     *
     * @param  string  $phoneNumber  The phone number to sanitise
     *
     * @return string The sanitised phone number
     */
    public function index(string $phoneNumber): string
    {
        $phoneNumber = match (blank($phoneNumber)) {
            true => $phoneNumber,
            default => Pipeline::send($phoneNumber)->through([
                RemovePlus::class,
                RemoveCountryCode::class,
                RemoveLeadingZero::class,
                ValidatePhoneNumber::class,
            ])->then(static fn ($phoneNumber): string => '254' . $phoneNumber),
        };

        return match (is_string($phoneNumber)) {
            true => $phoneNumber,
            default => '',
        };
    }
}
