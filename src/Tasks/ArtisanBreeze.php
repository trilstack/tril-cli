<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

final class ArtisanBreeze extends SimpleCommandTask implements TaskInterface
{
    protected string $command = "php artisan breeze:install react --typescript --no-interaction";
}
