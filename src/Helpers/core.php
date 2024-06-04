<?php

declare(strict_types=1);

use Atendwa\MpesaArtisan\Core\ValidateDriver;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

if (! function_exists('tannery')) {
    /**
     * Conditionally selects between two values based on a condition.
     *
     * @param  bool  $condition  The condition to evaluate.
     * @param  mixed  $first  The value to return if the condition is true.
     * @param  mixed  $second  The value to return if the condition is false.
     *
     * @return mixed The selected value.
     */
    function tannery(bool $condition, mixed $first, mixed $second): mixed
    {
        return $condition ? $first : $second;
    }
}

if (! function_exists('andCheck')) {
    /**
     * Performs a logical AND operation on two boolean values.
     *
     * @param  bool  $first  The first boolean value.
     * @param  bool  $second  The second boolean value.
     *
     * @return bool The result of the logical AND operation.
     */
    function andCheck(bool $first, bool $second): bool
    {
        return $first && $second;
    }
}

if (! function_exists('orCheck')) {
    /**
     * Performs a logical OR operation on two boolean values.
     *
     * @param  bool  $first  The first boolean value.
     * @param  bool  $second  The second boolean value.
     *
     * @return bool The result of the logical OR operation.
     */
    function orCheck(bool $first, bool $second): bool
    {
        return $first || $second;
    }
}

if (! function_exists('format_response_keys')) {
    function format_response_keys(Collection $response): Collection
    {
        return $response->mapWithKeys(
            static fn ($value, $key) => [Str::camel($key) => $value]
        );
    }
}

if (! function_exists('force_string')) {
    function force_string(mixed $value, string $default = ''): string
    {
        return match (is_string($value)) {
            default => $default,
            true => $value,
        };
    }
}

if (! function_exists('validate_driver')) {
    function validate_driver(array $driver): void
    {
        app(ValidateDriver::class)->index($driver);
    }
}

if (! function_exists('query_directory')) {
    function query_directory(string $code): array
    {
        $error = config('directory.' . $code);

        return match (is_array($error)) {
            true => $error,
            default => [
                'cause' => 'no record found',
                'solution' => 'Please refer to the documentation',
            ]
        };
    }
}

if (! function_exists('reduce_character')) {
    function reduce_character(
        string $original,
        string $character = '0'
    ): string {
        $value = str_replace($character, '', $original);

        return match (blank($value)) {
            default => $original,
            true => $character,
        };
    }
}

if (! function_exists('fetch_timestamp')) {
    /**
     * @return string The current timestamp.
     */
    function fetch_timestamp(): string
    {
        return Carbon::rawParse('now')->format('YmdHms');
    }
}
