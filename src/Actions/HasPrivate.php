<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

trait HasPrivate
{
    protected bool|string $private = false;

    public function private(string $to = null): static
    {
        $this->private = $to ?? true;

        return $this;
    }
}
