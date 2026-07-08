<?php

declare(strict_types=1);

namespace Xukera\Core;

use Xukera\Contracts\StorageInterface;

final class MemoryStorage implements StorageInterface
{
    private ?Graph $graph = null;

    public function save(Graph $graph): void
    {
        $this->graph = $graph;
    }

    public function load(): Graph
    {
        return $this->graph ?? new Graph();
    }
}
