<?php

declare(strict_types=1);

namespace TrilStack\Cli\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TrilStack\Cli\Context;
use TrilStack\Cli\Tasks\TaskException;
use TrilStack\Cli\Tasks\TaskInterface;

abstract class TaskedCommand extends Command
{
    /** @var array<string, class-string> */
    protected array $tasks = [];

    abstract protected function context(InputInterface $input): Context;

    /** @todo: replace output writes with fancy renders */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $render = new Renderer($input->hasOption('no-ansi') ? $input->getOption('no-ansi') ?? false : false);

        $render->welcome();

        $context = $this->context($input);

        foreach ($this->tasks as $title => $task) {
            /** @var TaskInterface $task */
            $task = new $task();

            try {
                $output->write("$title: <comment>loading...</comment>");

                try {
                    $result = $task->execute($context);
                    $isSuccess = $result->isSuccess();
                } catch (\Exception $taskException) {
                    $isSuccess = false;
                }

                $render->clearLine($output);

                $output->writeln("$title: ".($isSuccess ? '✅' : '❌'));

                if (isset($taskException)) {
                    throw $taskException;
                }

                if (isset($result) && !$isSuccess) {
                    throw new TaskException($result->getOutput());
                }
            } catch (TaskException $e) {
                // $render->error($e->getMessage());
                // Use collision package?
                $output->writeln("<error>{$e->getMessage()}</error>");
                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}
