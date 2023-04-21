<?php

declare(strict_types=1);

namespace ResponseActions;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use ResponseActions\Actions\Action;
use Traversable;

use function array_map;
use function count;
use function usort;

final class Collection implements \JsonSerializable, Countable, IteratorAggregate
{
    private int $maxOrder = 0;

    private array $actions = [];

    /**
     * @param Action ...$actions
     */
    public function __construct(Action ...$actions)
    {
        $this->addActions($actions);
    }

    public function addActions(array $actions): void
    {
        foreach ($actions as $action) {
            $this->addAction($action);
        }
    }

    public function addAction(Action $action): void
    {
        $this->changeMaxOrder($action->order());

        $this->actions[] = $action;
    }

    private function changeMaxOrder(int $actionOrder): void
    {
        if ($actionOrder !== 0) {
            if ($this->isEmpty() || $this->maxOrder < $actionOrder) {
                $this->maxOrder = $actionOrder;
            }
        }
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function all(): array
    {
        return $this->actions;
    }

    public function sort(): void
    {
        if ($this->maxOrder === 0) {
            return;
        }

        usort(
            $this->actions,
            fn(Action $a, Action $b) => $a->order() <=> $b->order()
        );
    }

    /**
     * @return array<string, mixed>[]
     */
    public function toArray(): array
    {
        $this->sort();
        return array_map(fn(Action $action) => $action->toArray(), $this->actions);
    }

    /**
     * @return array<string, mixed>[]
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function count(): int
    {
        return count($this->actions);
    }

    /**
     * @return Traversable<Action>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->actions);
    }
}
