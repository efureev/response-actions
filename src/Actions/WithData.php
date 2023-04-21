<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

trait WithData
{
    protected array $actionData = [];

    public function withData(array $data): static
    {
        $this->actionData = $data;

        return $this;
    }
}
