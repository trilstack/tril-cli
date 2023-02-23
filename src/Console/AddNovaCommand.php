<?php

declare(strict_types=1);

namespace TrilStack\Cli\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use TrilStack\Cli\Context;
use TrilStack\Cli\Tasks\ComposerUpdate;
use TrilStack\Cli\Tasks\RequireNova;

final class AddNovaCommand extends TaskedCommand
{
    protected static $defaultName = 'add:nova';

    protected array $tasks = [
        'Prepare Nova' => RequireNova::class,
        'Run Composer' => ComposerUpdate::class,
    ];

    protected function configure(): void
    {
        $this
            ->setDescription('Add Laravel Nova to the project.')
            ->addArgument('email', InputArgument::REQUIRED, 'Your Nova license email.')
            ->addArgument('license', InputArgument::REQUIRED, 'Your Nova license key.')
        ;
    }

    protected function context(InputInterface $input): Context
    {
        return Context::create([
            'projectPath' => getcwd() . '/test',
            'email' => $input->getArgument('email'),
            'license' => $input->getArgument('license'),
        ]);
    }
}
