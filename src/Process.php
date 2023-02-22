<?php

declare(strict_types=1);

namespace TrilStack\Cli;

use Symfony\Component\Process\Process as SymfonyProcess;

final class Process
{
    public static function run(string $command): SymfonyProcess
    {
        $process = new SymfonyProcess(explode(' ', $command));
        $process->run();

        return $process;
    }
}
