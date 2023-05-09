<?php

declare(strict_types=1);

namespace ResponseActions;

trait WithExtra
{
    protected array $extra = [];

    public function withExtra(array $extra): static
    {
        $this->extra = $extra;

        return $this;
    }

    public function isExtraEmpty(): bool
    {
        return count($this->extra) === 0;
    }
}
