<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Utilities\CommonBusinessAPI;

class BusinessPayBill
{
    use CommonBusinessAPI;

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.business_pay_bill'));
    }
}
