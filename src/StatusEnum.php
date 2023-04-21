<?php

declare(strict_types=1);

namespace ResponseActions;

enum StatusEnum: string
{
    case Success = 'success';

    case Info = 'info';

    case Error = 'error';

    case Warning = 'warning';

    case Nothing = '';
}
