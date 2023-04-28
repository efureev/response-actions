<?php

declare(strict_types=1);

namespace ResponseActions;

trait HasHttpCode
{
    protected int $httpCode = 200;

    public function setHttpCode(int $code): static
    {
        $this->httpCode = $code;

        return $this;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
