<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use ResponseActions\WithExtra;

final class Message extends AbstractMessage
{
    public function __construct(
        string $message,
        MessageTypeEnum $type = MessageTypeEnum::NOTHING
    ) {
        parent::__construct($message);

        $this->type = $type;
    }

    public static function info(string $message): self
    {
        return new self($message, MessageTypeEnum::INFO);
    }

    public static function success(string $message): self
    {
        return new self($message, MessageTypeEnum::SUCCESS);
    }

    public static function error(string $message): self
    {
        return new self($message, MessageTypeEnum::ERROR);
    }

    public static function warn(string $message): self
    {
        return new self($message, MessageTypeEnum::WARNING);
    }
}
