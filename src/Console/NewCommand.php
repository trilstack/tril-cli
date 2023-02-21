<?php

declare(strict_types=1);

namespace TrilStack\Cli\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TrilStack\Cli\Tasks\Context;
use TrilStack\Cli\Tasks\InstallLaravelTask;
use TrilStack\Cli\Tasks\TaskException;

final class NewCommand extends Command
{
    protected static $defaultName = 'new';

    private array $tasks = [
        'Install Laravel' => InstallLaravelTask::class,
    ];

    protected function configure(): void
    {
        $this
            ->setDescription('Create a new project with the TRIL stack.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the project.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $render = new Renderer($input->getOption('no-ansi') ?? false);

        $render->welcome();

        $context = Context::create([
            'name' => $input->getArgument('name'),
        ]);

        foreach ($this->tasks as $title => $task) {
            $task = new $task();
            try {
                $result = $render->task($output, $title, $task, $context);
            } catch (TaskException $e) {
                $output->writeln($e->getMessage());
                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}
