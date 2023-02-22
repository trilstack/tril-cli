<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

use TrilStack\Cli\Context;
use TrilStack\Cli\Process;

final class RequireBreeze implements TaskInterface
{
    public function execute(Context $context): TaskResult
    {
        chdir($context->getProjectPath());

        $process = Process::run("composer require laravel/breeze --dev --no-interaction --no-update");

        $output = $process->getOutput() === '' ? $process->getErrorOutput() : $process->getOutput();
        return new TaskResult($process->isSuccessful(), $output);
    }
}
