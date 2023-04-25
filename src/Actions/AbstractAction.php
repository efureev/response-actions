<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use ResponseActions\Maker;
use ResponseActions\Utils\Utils;

abstract class AbstractAction implements Action
{
    use Maker;
    use HasPrivate;

    protected int $order = 0;

    public function __toString(): string
    {
        return $this->name();
    }

    public function name(): string
    {
        return mb_strtolower(Utils::classBasename(static::class));
    }

    public function order(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): static
    {
        $this->order = $order;

        return $this;
    }

    abstract protected function toActionArray(): array;

    public function toArray(): array
    {
        return array_merge(
            [
                'name'  => $this->name(),
                'order' => $this->order(),
            ],
            $this->private ? ['private' => $this->private] : [],
            $this->toActionArray()
        );
    }
}
