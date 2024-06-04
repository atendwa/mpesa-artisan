<?php

namespace Atendwa\MpesaArtisan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MpesaResponse extends Model
{
    protected $guarded = [];

    protected $with = ['transaction'];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(MpesaTransaction::class);
    }

    protected function casts(): array
    {
        return [
            '',
        ];
    }
}
