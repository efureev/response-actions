<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

enum MessageTypeEnum: string
{
    case Success = 'success';

    case Info = 'info';

    case Error = 'error';

    case Warning = 'warning';
}
