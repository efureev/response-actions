<?php

declare(strict_types=1);

namespace ResponseActions;

trait WithExtra
{
    /**
     * @var array<string, mixed>
     */
    protected array $extra = [];

    public function withExtra(array $extra): static
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * True when no extra data is present.
     */
    public function hasNoExtra(): bool
    {
        return empty($this->extra);
    }
}
