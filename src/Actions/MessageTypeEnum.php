<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

enum MessageTypeEnum: string implements \JsonSerializable
{
    case SUCCESS = 'success';
    case INFO    = 'info';
    case ERROR   = 'error';
    case WARNING = 'warning';
    case NOTHING = '';

    public function is(self $type): bool
    {
        return $this === $type;
    }

    public function isSuccess(): bool
    {
        return $this === self::SUCCESS;
    }

    public function isError(): bool
    {
        return $this === self::ERROR;
    }

    public function isInfo(): bool
    {
        return $this === self::INFO;
    }

    public function isWarning(): bool
    {
        return $this === self::WARNING;
    }

    public function isNothing(): bool
    {
        return $this === self::NOTHING;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
