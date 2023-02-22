<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

final class NpmBuild extends SimpleCommandTask implements TaskInterface
{
    protected string $command = "npm install --no-interaction --no-progress --no-audit --no-fund";
}
