<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

interface TaskInterface
{
    public function execute(Context $context): TaskResult;
}
