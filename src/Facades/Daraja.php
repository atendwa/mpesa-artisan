<?php

namespace Atendwa\MpesaArtisan\Facades;

use Illuminate\Support\Facades\Facade;

class Daraja extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Atendwa\MpesaArtisan\Core\Daraja::class;
    }
}
