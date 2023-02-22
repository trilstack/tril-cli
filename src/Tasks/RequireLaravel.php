<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

use TrilStack\Cli\Context;

final class RequireLaravel extends SimpleCommandTask implements TaskInterface
{
    protected bool $runInProjectDirectory = false;

    public function command(Context $context): string
    {
        $name = $context->get('name');

        return "composer create-project --prefer-dist --no-install --no-progress --no-scripts --no-plugins --no-interaction laravel/laravel $name";
    }
}
