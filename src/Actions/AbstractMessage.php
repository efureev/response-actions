<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use JsonSerializable;
use ResponseActions\WithExtra;
use Stringable;

abstract class AbstractMessage extends AbstractAction
{
    use WithExtra;

    public function __construct(
        public readonly JsonSerializable|Stringable|string $message,
    ) {
    }

    protected MessageTypeEnum $type;

    public function isNothing(): bool
    {
        return $this->type->isNothing();
    }

    public function setType(MessageTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getType(): MessageTypeEnum
    {
        return $this->type;
    }

    public function setTypeFromString(string $value): void
    {
        $this->type = MessageTypeEnum::tryFrom($value) ?? $this->type;
    }

    /**
     * @return array{
     *   message:string|JsonSerializable,
     *   type?:MessageTypeEnum,
     *   extra?:array<string, mixed>
     * }
     */
    protected function toActionArray(): array
    {
        /** @var string|JsonSerializable $msg */
        $msg = is_string($this->message) || $this->message instanceof Stringable
            ? (string)$this->message
            : $this->message;

        return ['message' => $msg] + $this->addOptionalFields();
    }

    /**
     * @return array{
     *   type?:MessageTypeEnum,
     *   extra?:array<string, mixed>
     * }
     */
    private function addOptionalFields(): array
    {
        $result = [];
        if (!$this->isNothing()) {
            $result['type'] = $this->type;
        }

        if (!$this->hasNoExtra()) {
            $result['extra'] = $this->extra;
        }

        return $result;
    }
}
