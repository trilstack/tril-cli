<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

use TrilStack\Cli\Context;
use TrilStack\Cli\Process;

final class ComposerUpdate extends SimpleCommandTask implements TaskInterface
{
    protected string $command = "composer update --no-interaction";
}
