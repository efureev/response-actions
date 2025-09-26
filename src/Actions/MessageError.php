<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

class MessageError extends Message
{
    private const int DEFAULT_EMPTY_INT_CODE = 0;

    public function __construct(string $message, private int|string|null $code = null)
    {
        parent::__construct($message, MessageTypeEnum::ERROR);
    }

    public function code(): int|string|null
    {
        return $this->code;
    }

    public function withCode(int|string|null $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return array{
     *   message:string,
     *   type?:string,
     *   extra?:array<string, mixed>,
     *   code?:int|string|null
     * }
     */
    protected function toActionArray(): array
    {
        $result = parent::toActionArray();

        if ($this->hasCode()) {
            $result['code'] = $this->code;
        }

        return $result;
    }

    private function hasCode(): bool
    {
        return !$this->hasNoCode();
    }

    private function hasNoCode(): bool
    {
        if (is_string($this->code)) {
            return $this->code === '';
        }

        if (is_int($this->code)) {
            return $this->code === self::DEFAULT_EMPTY_INT_CODE;
        }

        return $this->code === null;
    }
}
