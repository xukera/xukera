<?php

declare(strict_types=1);

namespace Xukera\Contracts;

use Xukera\Core\Graph;

interface StorageInterface
{
    public function save(Graph $graph): void;

    public function load(): Graph;
}
