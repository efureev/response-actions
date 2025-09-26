<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use JsonSerializable;

enum CommandStatus: string implements JsonSerializable
{
    case Done = 'done';

    case Failed = 'failed';

    case Pending = 'pending';

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
