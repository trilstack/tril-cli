<?php

declare(strict_types=1);

namespace TrilStack\Cli\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use TrilStack\Cli\Context;
use TrilStack\Cli\Tasks\ArtisanBreeze;
use TrilStack\Cli\Tasks\ComposerUpdate;
use TrilStack\Cli\Tasks\CopyEnv;
use TrilStack\Cli\Tasks\GenerateKey;
use TrilStack\Cli\Tasks\NpmBuild;
use TrilStack\Cli\Tasks\RequireLaravel;
use TrilStack\Cli\Tasks\RequireBreeze;

final class NewCommand extends TaskedCommand
{
    protected static $defaultName = 'new';

    protected array $tasks = [
        'Prepare Laravel' => RequireLaravel::class,
        'Prepare Breeze' => RequireBreeze::class,
        'Run Composer' => ComposerUpdate::class,
        'Run Breeze' => ArtisanBreeze::class,
        'Install assets' => NpmBuild::class,
        'Copy .env' => CopyEnv::class,
        'Generate application key' => GenerateKey::class,
    ];

    protected function configure(): void
    {
        $this
            ->setDescription('Create a new project with the TRIL stack.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the project.')
        ;
    }

    protected function context(InputInterface $input): Context
    {
        return Context::create([
            'projectPath' => getcwd() . '/' . $input->getArgument('name'),
            'name' => $input->getArgument('name'),
        ]);
    }
}
