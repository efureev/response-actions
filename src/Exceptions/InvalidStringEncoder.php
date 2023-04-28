<?php

declare(strict_types=1);

namespace ResponseActions\Exceptions;

final class InvalidStringEncoder extends \Exception
{
    public function __construct(string $algo)
    {
        parent::__construct("Invalid StringEncoder: $algo");
    }
}
