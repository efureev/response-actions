<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use Stringable;

interface Action extends Stringable
{
    public function name(): string;

    public function order(): int;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
