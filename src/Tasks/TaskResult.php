<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

final class TaskResult
{
    public function __construct(
        private readonly bool $success,
        private readonly string $output,
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getOutput(): string
    {
        return $this->output;
    }
}
