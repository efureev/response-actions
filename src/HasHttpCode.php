<?php

declare(strict_types=1);

namespace ResponseActions;

trait HasHttpCode
{
    private const int DEFAULT_HTTP_CODE = 200;

    protected int $httpCode = self::DEFAULT_HTTP_CODE;

    public function withStatusCode(int $statusCode): static
    {
        if ($statusCode < 100 || $statusCode > 599) {
            throw new \InvalidArgumentException("Invalid HTTP status code: $statusCode");
        }

        $this->httpCode = $statusCode;

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->httpCode;
    }
}
