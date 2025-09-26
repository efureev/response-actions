<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use ResponseActions\WithExtra;
use Stringable;

abstract class AbstractMessage extends AbstractAction
{
    use WithExtra;

    public function __construct(
        public readonly Stringable|string $message,
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
     *   message:string,
     *   type?:MessageTypeEnum,
     *   extra?:array<string, mixed>
     * }
     */
    protected function toActionArray(): array
    {
        return ['message' => (string)$this->message] + $this->addOptionalFields();
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
