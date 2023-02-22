<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

use TrilStack\Cli\Context;
use TrilStack\Cli\Process;

abstract class SimpleCommandTask
{
    protected string $command;

    protected bool $runInProjectDirectory = true;

    protected function command(Context $context): string
    {
        return $this->command;
    }

    public function execute(Context $context): TaskResult
    {
        if ($this->runInProjectDirectory) {
            Process::runInProjectDirectory($context);
        }

        $process = Process::run($this->command($context));

        $output = $process->getOutput() === '' ? $process->getErrorOutput() : $process->getOutput();
        return new TaskResult($process->isSuccessful(), $output);
    }
}
