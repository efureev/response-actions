<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use ResponseActions\WithExtra;

class Message extends AbstractAction
{
    use WithExtra;

    public function __construct(
        public readonly string $message,
        protected MessageTypeEnum $type = MessageTypeEnum::NOTHING
    ) {
    }

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
     *   type?:string,
     *   extra?:array<string, mixed>
     * }
     */
    protected function toActionArray(): array
    {
        $result = ['message' => $this->message];

        $this->addOptionalFields($result);

        return $result;
    }

    /**
     * @param array<string, mixed> $result
     */
    private function addOptionalFields(array &$result): void
    {
        if (!$this->isNothing()) {
            $result['type'] = $this->type;
        }

        if (!$this->hasNoExtra()) {
            $result['extra'] = $this->extra;
        }
    }

    public static function info(string $message): static
    {
        return new static($message, MessageTypeEnum::INFO);
    }

    public static function success(string $message): static
    {
        return new static($message, MessageTypeEnum::SUCCESS);
    }

    public static function error(string $message): static
    {
        return new static($message, MessageTypeEnum::ERROR);
    }

    public static function warn(string $message): static
    {
        return new static($message, MessageTypeEnum::WARNING);
    }
}
