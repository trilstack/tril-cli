<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

final class GenerateKey extends SimpleCommandTask implements TaskInterface
{
    protected string $command = "php artisan key:generate";
}
