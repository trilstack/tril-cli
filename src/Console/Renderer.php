<?php

declare(strict_types=1);

namespace TrilStack\Cli\Console;

use Symfony\Component\Console\Output\OutputInterface;
use TrilStack\Cli\Tasks\Context;
use TrilStack\Cli\Tasks\TaskException;
use TrilStack\Cli\Tasks\TaskInterface;
use function Termwind\render;

final class Renderer
{
    public function __construct(
        private bool $rawOutput = false
    ) {
    }

    public function welcome(): void
    {
        $tril = '<span class="text-sky-500">T</span><span class="text-cyan-500">R</span><span class="text-indigo-500">I</span><span class="text-red-500">L</span>';

        $this->render("<div class='p-1 m-1 w-1/3 text-center font-bold'>Welcome to the $tril stack!</div>");
    }

    public function task(OutputInterface $output, string $title, TaskInterface $task = null, Context $context, $loadingText = 'loading...'): bool
    {
        $output->write("$title: <comment>{$loadingText}</comment>");

        if ($task === null) {
            $isSuccess = true;
        } else {
            try {
                $result = $task->execute($context);
                $isSuccess = $result->isSuccess();
            } catch (\Exception $taskException) {
                $isSuccess = false;
            }
        }

        if ($output->isDecorated()) { // Determines if we can use escape sequences
            // Move the cursor to the beginning of the line
            $output->write("\x0D");

            // Erase the line
            $output->write("\x1B[2K");
        } else {
            $output->writeln(''); // Make sure we first close the previous line
        }

        $output->writeln(
            "$title: ".($isSuccess ? '<info>✔</info>' : '<error>failed</error>')
        );

        if (isset($taskException)) {
            throw $taskException;
        } elseif (!$isSuccess) {
            throw new TaskException($result->getOutput());
        }

        return $isSuccess;
    }

//    public function title(string $message): void
//    {
//        $this->render("<div class='p-1 m-1 w-1/3 bg-teal-300 text-center text-teal-900 font-bold'>$message</div>");
//    }

//    public function success(string $message): void
//    {
//        $this->render("<div class='p-1 m-1 w-1/3 bg-green-300 text-center text-teal-900 font-bold'>$message</div>");
//    }
//
//    public function error(string $title, array $messages): void
//    {
//        $map = array_map(fn (string $message) => "<dd class='pt-1'>$message</dd>", $messages);
//        $list = implode('', $map);
//
//        $html = "
//            <div>
//                <div class='my-1'>
//                    <dl>
//                        <dt class='bg-red-500 w-full font-bold p-1 text-white'>$title</dt>
//                        $list
//                    </dl>
//                </div>
//            </div>
//        ";
//
//        $this->render($html);
//    }

    private function render(string $html): void
    {
        if ($this->rawOutput) {
            $html = preg_replace("(class='(.*)')", '', $html);
        }

        render($html);
    }
}
