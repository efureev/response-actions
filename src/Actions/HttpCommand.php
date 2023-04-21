<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

/**
 * @method static static make(CommandStatus $status, string $description = null)
 */
class HttpCommand extends Command
{
    protected int $httpCode = 200;


    public function setHttpCode(int $code): static
    {
        $this->httpCode = $code;

        return $this;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
