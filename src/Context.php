<?php

declare(strict_types=1);

namespace TrilStack\Cli;

use Webmozart\Assert\Assert;

final class Context
{
    private function __construct(
        private array $data
    )
    {
    }

    public function get(string $key): mixed
    {
        return $this->data[$key];
    }

    public static function create(array $data): Context
    {
        Assert::keyExists($data, 'projectPath');
        return new self($data);
    }

    public function getProjectPath(): string
    {
        return $this->get('projectPath');
    }
}
