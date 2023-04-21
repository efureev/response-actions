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
}
