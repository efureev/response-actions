<?php

declare(strict_types=1);

namespace ResponseActions\Utils;

class Utils
{
    /**
     * Returns the short (base) name of a class.
     *
     * Accepts either an object instance or a fully-qualified class name.
     *
     * @param class-string|object $class
     *
     * Examples:
     * - Utils::getClassBasename(\DateTime::class) => "DateTime"
     * - Utils::getClassBasename(new \DateTime()) => "DateTime"
     */
    public static function classBasename(string|object $class): string
    {
        $fqcn = \is_object($class) ? $class::class : $class;

        return \basename(\str_replace('\\', '/', $fqcn));
    }
}
