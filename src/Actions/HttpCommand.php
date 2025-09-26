<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use ResponseActions\HasHttpCode;
use ResponseActions\ShouldHasHttpCode;

class HttpCommand extends Command implements ShouldHasHttpCode
{
    use HasHttpCode;
}
