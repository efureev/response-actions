<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use ResponseActions\HasHttpCode;
use ResponseActions\ShouldHasHttpCode;

/**
 * @method static static make(CommandStatus $status = CommandStatus::Pending, string $description = null)
 */
class HttpCommand extends Command implements ShouldHasHttpCode
{
    use HasHttpCode;
}
