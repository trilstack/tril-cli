<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

use Symfony\Component\Process\Process;

final class InstallLaravelTask implements TaskInterface
{
    public function execute(Context $context): TaskResult
    {
        $name = $context->get('name');

        $process = new Process(['composer', 'create-project', '--prefer-dist', '--no-install','--no-progress','--no-scripts','--no-scripts','--no-plugins', '--no-interaction', 'laravel/laravel', $name]);
        $process->run();

        $output = $process->getOutput() === '' ? $process->getErrorOutput() : $process->getOutput();
        return new TaskResult($process->isSuccessful(), $output);
    }
}
