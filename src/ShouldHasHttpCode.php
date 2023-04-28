<?php

declare(strict_types=1);

namespace ResponseActions;

interface ShouldHasHttpCode
{
    public function getHttpCode(): int;

    public function setHttpCode(int $code): static;
}
