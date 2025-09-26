<?php

declare(strict_types=1);

namespace ResponseActions;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use ResponseActions\Actions\Action;
use Traversable;

use function array_map;
use function count;
use function usort;

final class Collection implements JsonSerializable, Countable, IteratorAggregate
{
    private int $maxOrder = 0;

    /** @var list<Action> */
    private array $actions = [];

    /**
     * @param Action ...$actions
     */
    public function __construct(Action ...$actions)
    {
        $this->addActions(...$actions);
    }

    public function addActions(Action ...$actions): void
    {
        foreach ($actions as $action) {
            $this->addAction($action);
        }
    }

    public function addAction(Action $action): void
    {
        $this->updateMaxOrder($action->order());

        $this->actions[] = $action;
    }

    private function updateMaxOrder(int $actionOrder): void
    {
        if ($actionOrder === 0) {
            return;
        }


        if ($this->isEmpty() || $this->maxOrder < $actionOrder) {
            $this->maxOrder = $actionOrder;
        }
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @return list<Action>
     */
    public function all(): array
    {
        return $this->actions;
    }

    public function first(): ?Action
    {
        return $this->actions[0] ?? null;
    }

    public function sortByOrder(): void
    {
        if ($this->maxOrder === 0) {
            return;
        }

        usort(
            $this->actions,
            static function (Action $a, Action $b): int {
                $byOrder = $a->order() <=> $b->order();
                return $byOrder !== 0 ? $byOrder : ($a->name() <=> $b->name());
            }
        );
    }

    /**
     * @return array<string, mixed>[]
     */
    public function toArray(): array
    {
        $this->sortByOrder();

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
