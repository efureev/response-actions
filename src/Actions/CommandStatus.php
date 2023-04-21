<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

enum CommandStatus: string
{
    case Done = 'done';

    case Failed = 'failed';
}
