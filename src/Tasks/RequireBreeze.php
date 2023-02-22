<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

final class RequireBreeze extends SimpleCommandTask implements TaskInterface
{
    protected string $command = "composer require laravel/breeze --dev --no-interaction --no-update";
}
