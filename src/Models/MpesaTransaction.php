<?php

namespace Atendwa\MpesaArtisan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MpesaTransaction extends Model
{
    protected $guarded = [];

    protected $with = ['payload', 'response'];

    public function payload(): HasOne
    {
        return $this->hasOne(MpesaPayload::class);
    }

    public function response(): HasOne
    {
        return $this->hasOne(MpesaResponse::class);
    }

    protected function casts(): array
    {
        return [
            '',
        ];
    }
}
