<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait Remarks
{
    private string $remarks = '';

    public function remarks(string $value): self
    {
        $this->remarks = $value;

        return $this;
    }

    protected function defaultRemark(string $default): void
    {
        $remark = $this->remarks;
        $value = tannery(filled($remark), $remark, $default);
        $this->remarks = force_string($value);
    }
}
