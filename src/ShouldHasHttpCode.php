<?php

declare(strict_types=1);

namespace ResponseActions;

interface ShouldHasHttpCode
{
    /**
     * HTTP status code getter.
     */
    public function getStatusCode(): int;

    /**
     * Fluent setter for HTTP status code.
     */
    public function withStatusCode(int $statusCode): static;
}
