<?php

declare(strict_types=1);

namespace ResponseActions;

trait Maker
{
    /**
     * Create a new element.
     *
     * @param mixed ...$arguments
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        // @phpstan-ignore-next-line
        return new static(...$arguments);
    }
}
