<?php

declare(strict_types=1);

namespace ResponseActions;

use ResponseActions\Actions\Action;
use ResponseActions\Actions\Message;

/**
 * @method static self make(StatusEnum $status, Action ...$action)
 */
class ResponseAction
{
    use Maker;
    use WithExtra;
    use WithWrappers;

    private string $responseKey = 'actionMessage';

    private Collection $actions;

    public function __construct(private StatusEnum $status = StatusEnum::Nothing, Action ...$action)
    {
        $this->actions = new Collection(...$action);
    }

    public function setResponseKey(string $name): void
    {
        $this->responseKey = $name;
    }

    public function responseKey(): string
    {
        return $this->responseKey;
    }

    public function actions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action ...$actions): self
    {
        foreach ($actions as $action) {
            if ($action instanceof Message && !$action->hasType()) {
                $action->setTypeFromString($this->status->value);
            }
        }

        $this->actions->addActions($actions);

        return $this;
    }

    public function is(StatusEnum $type): bool
    {
        return $this->status === $type;
    }

    public function isNothing(): bool
    {
        return $this->is(StatusEnum::Nothing);
    }

    public function isError(): bool
    {
        return $this->is(StatusEnum::Error);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'status' => $this->status->value,
        ];

        if (!$this->actions->isEmpty()) {
            $result['actions'] = $this->actions->toArray();
        }

        if (count($this->extra) > 0) {
            $result['extra'] = $this->extra;
        }

        return $result;
    }

    public function wrap(string $key = null): array
    {
        $key ??= $this->responseKey;

        return [
            $key => $this->toArray(),
        ];
    }
}
