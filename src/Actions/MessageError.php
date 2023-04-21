<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

/**
 * @method static static make(string $message, int|string $code = null)
 */
class MessageError extends Message
{
    public function __construct(string $message, private int|string|null $code = null)
    {
        parent::__construct($message, MessageTypeEnum::Error);
    }

    public function code(): int|string|null
    {
        return $this->code;
    }

    public function setCode(int|string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return array{message:string}|array{message:string, type:string}|array{message:string, type:string, code:int}|array{message:string, code:int}
     */
    protected function toActionArray(): array
    {
        $result = parent::toActionArray();
        if (!$this->isEmptyCode()) {
            $result['code'] = $this->code;
        }

        return $result;
    }

    private function isEmptyCode(): bool
    {
        if (is_string($this->code)) {
            return $this->code === '';
        }

        if (is_int($this->code)) {
            return $this->code === 0;
        }

        return $this->code === null;
    }
}
