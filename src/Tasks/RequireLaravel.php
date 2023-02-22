<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

use TrilStack\Cli\Context;
use TrilStack\Cli\Process;

final class RequireLaravel implements TaskInterface
{
    public function execute(Context $context): TaskResult
    {
        $name = $context->get('name');

        $process = Process::run("composer create-project --prefer-dist --no-install --no-progress --no-scripts --no-plugins --no-interaction laravel/laravel $name");

        $output = $process->getOutput() === '' ? $process->getErrorOutput() : $process->getOutput();
        return new TaskResult($process->isSuccessful(), $output);
    }
}
