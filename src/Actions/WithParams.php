<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

trait WithParams
{
    /**
     * @var array<string, mixed>
     */
    protected array $params = [];

    /**
     * Replace all parameters at once.
     *
     * @param array<string, mixed> $params
     */
    public function withParams(array $params): static
    {
        $this->params = $params;

        return $this;
    }
}
