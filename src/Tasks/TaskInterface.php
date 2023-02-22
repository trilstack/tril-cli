<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

use TrilStack\Cli\Context;

interface TaskInterface
{
    public function execute(Context $context): TaskResult;
}
