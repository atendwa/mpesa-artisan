<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Services;

use Atendwa\MpesaArtisan\Concerns\Utilities\CommonBusinessAPI;

class BusinessBuyGoods
{
    use CommonBusinessAPI;

    protected function endpoint(): string
    {
        return force_string(config('mpesa.endpoints.business_buy_goods'));
    }
}
