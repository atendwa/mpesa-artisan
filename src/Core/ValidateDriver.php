<?php

namespace Atendwa\MpesaArtisan\Core;

use Exception;
use Throwable;

class ValidateDriver
{
    public function index(array $original): void
    {
        $keys = [
            'initiator_name', 'passkey', 'security_credential',
            'shortcodes', 'key_pairs', 'callbacks',
        ];
        $this->validateSegment($original, $keys);

        $keys = ['business', 'payment'];
        $this->validateSegment($original['shortcodes'], $keys);
        $this->validateSegment($original['key_pairs'], ['consumer', 'payment']);

        $keys = ['key', 'secret'];
        $this->validateSegment($original['key_pairs']['consumer'], $keys);
        $this->validateSegment($original['key_pairs']['payment'], $keys);

        $keys = ['default', 'default_timeout_url'];
        $this->validateSegment($original['callbacks'], $keys);
    }

    private function validateSegment(array $driver, array $keys): void
    {
        collect($keys)->each(
            /**
             * @throws Throwable
             */
            fn ($key) => $this->verifyKey($key, $driver)
        );
    }

    /**
     * @throws Throwable
     */
    private function verifyKey(string $key, array $driver): void
    {
        $invalid = ! array_key_exists($key, $driver);
        $message = 'The mpesa driver is missing the key: ' . $key;
        throw_if($invalid, new Exception($message));
    }
}
