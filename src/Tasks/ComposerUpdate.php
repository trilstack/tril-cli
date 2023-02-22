<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

use TrilStack\Cli\Context;
use TrilStack\Cli\Process;

final class ComposerUpdate implements TaskInterface
{
    public function execute(Context $context): TaskResult
    {
        chdir($context->getProjectPath());

        $process = Process::run("composer update --no-interaction");

        $output = $process->getOutput() === '' ? $process->getErrorOutput() : $process->getOutput();
        return new TaskResult($process->isSuccessful(), $output);
    }
}
