<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use ResponseActions\WithExtra;

/**
 * @method static static make(string $message, MessageTypeEnum $type = MessageTypeEnum::Nothing)
 */
class Message extends AbstractAction
{
    use WithExtra;

    public function __construct(
        public readonly string $message,
        protected MessageTypeEnum $type = MessageTypeEnum::Nothing
    ) {
    }

    public function isNothing(): bool
    {
        return $this->type === MessageTypeEnum::Nothing;
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
        $type = MessageTypeEnum::tryFrom($value);
        if ($type !== null) {
            $this->setType($type);
        }
    }

    /**
     * @return array{message:string}|array{message:string, type:string}
     */
    protected function toActionArray(): array
    {
        $result = ['message' => $this->message];
        if (!$this->isNothing()) {
            $result['type'] = $this->type->value;
        }

        if (!$this->isExtraEmpty()) {
            $result['extra'] = $this->extra;
        }

        return $result;
    }

    public static function info(string $message): static
    {
        return static::make($message, MessageTypeEnum::Info);
    }

    public static function success(string $message): static
    {
        return static::make($message, MessageTypeEnum::Success);
    }

    public static function error(string $message): static
    {
        return static::make($message, MessageTypeEnum::Error);
    }

    public static function warn(string $message): static
    {
        return static::make($message, MessageTypeEnum::Warning);
    }
}
