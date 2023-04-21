<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

trait WithParams
{
    protected array $params = [];

    public function withParams(array $params): static
    {
        $this->params = $params;

        return $this;
    }
}
