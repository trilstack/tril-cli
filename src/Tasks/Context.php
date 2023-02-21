<?php

declare(strict_types=1);

namespace TrilStack\Cli\Tasks;

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
        return new self($data);
    }
}
