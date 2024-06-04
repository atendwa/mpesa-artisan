<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Support\API;

use Atendwa\MpesaArtisan\Concerns\Core\Driver;
use Exception;
use Illuminate\Support\Facades\File;
use Throwable;

class SecurityCredential
{
    use Driver;

    /**
     * @throws Throwable
     */
    public function generate(): string
    {
        validate_driver($this->driver);

        $securityCredential = $this->fetchSecurityCredential();
        $cert = $this->fetchCertificate();
        openssl_public_encrypt($securityCredential, $encrypted, $cert);

        return base64_encode($encrypted);
    }

    /**
     * @throws Throwable
     */
    private function fetchSecurityCredential(): string
    {
        $value = $this->driver['security_credential'];
        $message = 'Security Credential is not set!';
        throw_if(blank($value), new Exception($message));

        return $value;
    }

    /**
     * @return string The fetched certificate
     */
    private function fetchCertificate(): string
    {
        $base = 'vendor/atendwa/mpesa-artisan/src/Storage/Certificates/';
        $certName = match (config('mpesa.environment')) {
            'sandbox' => 'sandbox.cert',
            default => 'live.cert',
        };

        return File::get(base_path($base . $certName));
    }
}
