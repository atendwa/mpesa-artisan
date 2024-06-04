<?php

declare(strict_types=1);

use Atendwa\MpesaArtisan\Support\ParseResponse;
use Atendwa\MpesaArtisan\Support\SanitisePhoneNumber;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

if (! function_exists('default_mpesa_driver')) {
    function default_mpesa_driver(): string
    {
        $value = config('mpesa.configuration.default_driver');

        return force_string($value, 'default');
    }
}

if (! function_exists('default_short_code')) {
    /**
     * Retrieves the default short code
     *
     * @param  bool  $useConsumerKeyPair  Whether to use the consumer key pair.
     * @param  array  $driver  The driver configuration.
     *
     * @return string The default short code.
     */
    function default_short_code(
        bool $useConsumerKeyPair,
        array $driver
    ): string {
        validate_driver($driver);

        return match ($useConsumerKeyPair) {
            true => $driver['shortcodes']['business'],
            false => $driver['shortcodes']['payment'],
        };
    }
}

if (! function_exists('access_token_key')) {
    /**
     * Retrieve the key used to store the access token in the cache.
     */
    function access_token_key(): string
    {
        return config('mpesa.cache.prefix') . '_access_token';
    }
}

if (! function_exists('fetch_base_url')) {
    function fetch_base_url(): string
    {
        $url = match (config('mpesa.environment')) {
            'sandbox' => config('mpesa.urls.sandbox'),
            default => config('mpesa.urls.live'),
        };

        return force_string($url);
    }
}

if (! function_exists('parse_account_balance')) {
    /**
     * Parse & format the account balance value into a collection.
     *
     * @param  string  $result  The account balance value to parse.
     *
     * @return Collection the parsed and formatted account balance data.
     */
    function parse_account_balance(string $result): Collection
    {
        $result = collect(explode('&', $result));
        $parsed = collect();

        $result->each(static function ($value) use ($parsed): void {
            $position = mb_strpos($value, '|');

            if ($position === false) {
                return;
            }

            $key = mb_substr($value, 0, $position);
            $value = str_replace($key . '|KES|', '', $value);
            $value = collect(array_unique(explode('|', $value)));

            $max = $value->max();
            $value = tannery($max > 0, $max, $value->min());
            $parsed->put(Str::camel($key), $value);
        });

        return $parsed;
    }
}

if (! function_exists('parse_response')) {
    function parse_response(Collection $value): Collection
    {
        return app(ParseResponse::class)->index($value);
    }
}

if (! function_exists('sanitise_phone_number')) {
    /**
     * @throws Throwable
     */
    function sanitise_phone_number(string $phoneNumber): string
    {
        return app(SanitisePhoneNumber::class)->index($phoneNumber);
    }
}
