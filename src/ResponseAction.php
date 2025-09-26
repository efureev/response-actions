<?php

declare(strict_types=1);

namespace ResponseActions;

use ResponseActions\Actions\Action;
use ResponseActions\Actions\Message;
use ResponseActions\Exceptions\InvalidStringEncoder;
use ResponseActions\Utils\B64;

class ResponseAction
{
    use WithExtra;
    use WithWrappers;

    private const string DEFAULT_RESPONSE_KEY = '_responseAction';
    private const int JSON_FLAGS = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
    private const string DEFAULT_ENCODING_ALGO = 'b64Safe';


    private string $responseKey = self::DEFAULT_RESPONSE_KEY;

    /**
     * @var Collection<int,Action>
     */
    private Collection $actions;

    public function __construct(private StatusEnum $status = StatusEnum::NOTHING, Action ...$action)
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

    /**
     * @return Collection<int, Action>
     */
    public function actions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action ...$actions): self
    {
        foreach ($actions as $action) {
            if ($action instanceof Message && $action->isNothing()) {
                $action->setTypeFromString($this->status->value);
            }
        }

        $this->actions->addActions(...$actions);

        return $this;
    }

    public function is(StatusEnum $type): bool
    {
        return $this->status->is($type);
    }

    public function isNothing(): bool
    {
        return $this->status->isNothing();
    }

    public function isError(): bool
    {
        return $this->status->isError();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'status' => $this->status,
        ];

        if ($this->hasActions()) {
            $result['actions'] = $this->actions->toArray();
        }

        if (!$this->hasNoExtra()) {
            $result['extra'] = $this->extra;
        }

        return $result;
    }

    private function hasActions(): bool
    {
        return !$this->actions->isEmpty();
    }

    /**
     * @return array<string, mixed>
     */
    public function wrap(?string $key = null): array
    {
        $key ??= $this->responseKey;

        return [
            $key => $this->toArray(),
        ];
    }

    public function toString(?string $key = null): ?string
    {
        $json = \json_encode($this->wrap($key), self::JSON_FLAGS);

        return $json ?: null;
    }

    /**
     * @throws InvalidStringEncoder
     */
    public function toEncodedString(?string $key = null, string $algo = self::DEFAULT_ENCODING_ALGO): ?string
    {
        $str = $this->toString($key);
        if ($str === null) {
            return null;
        }

        return match ($algo) {
            'b64Safe' => B64::encodeUrlSafe($str),
            'b64' => B64::encode($str),
            default => throw new InvalidStringEncoder($algo),
        };
    }
}
