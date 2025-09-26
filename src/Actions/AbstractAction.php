<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use ResponseActions\Utils\Utils;

abstract class AbstractAction implements Action
{
    protected int $order = 0;

    protected bool|string $private = false;

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

    public function private(?string $to = null): static
    {
        $this->private = $to ?? true;

        return $this;
    }

    public function withOrder(int $order): static
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function toActionArray(): array;

    /**
     * @return array<string, mixed>
     */
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
