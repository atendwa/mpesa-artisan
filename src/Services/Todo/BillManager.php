<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services\Todo;

use Atendwa\MpesaArtisan\Concerns\Core\API;

class BillManager
{
    use API;

    protected function endpoint(): string
    {
        return force_string(config(''));
    }

    protected function preload(): void
    {
    }

    protected function fillPayload(): void
    {
    }
}
