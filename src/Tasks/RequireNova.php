<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

use TrilStack\Cli\Context;
use TrilStack\Cli\Process;

final class RequireNova implements TaskInterface
{
    protected function commands(Context $context): array
    {
        $email = $context->get('email');
        $license = $context->get('license');

        $setupNovaAuth = "composer config http-basic.nova.laravel.com $email $license";
        $setupRepo = 'composer config repositories.nova composer https://nova.laravel.com --file composer.json';
        $requireNova = 'composer require laravel/nova --no-interaction --no-update';

        return [$setupNovaAuth, $setupRepo, $requireNova];
    }

    public function execute(Context $context): TaskResult
    {
        Process::runInProjectDirectory($context);

        $commands = $this->commands($context);

        foreach ($commands as $command) {
            $process = Process::run($command);


            $output = $process->getOutput() === '' ? $process->getErrorOutput() : $process->getOutput();

            if (!$process->isSuccessful()) {
                return new TaskResult(false, $process->getErrorOutput());
            }

            if ($command === end($commands)) {
                return new TaskResult($process->isSuccessful(), $output);
            }
        }

        return new TaskResult(true, 'Nova installed successfully');
    }
}
