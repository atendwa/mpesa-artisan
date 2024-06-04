<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Concerns\Utilities;

trait Occasion
{
    private string $occasion = '';

    public function occasion(string $value): self
    {
        $this->occasion = $value;

        return $this;
    }

    protected function defaultOccasion(string $default): void
    {
        $remark = $this->occasion;
        $value = tannery(filled($remark), $remark, $default);
        $this->occasion = force_string($value);
    }
}
