<?php

declare(strict_types=1);

namespace Xukera\Tests;

use PHPUnit\Framework\TestCase;
use Xukera\Core\Graph;
use Xukera\Storage\MemoryStorage;

final class MemoryStorageTest extends TestCase
{
    public function testGraphCanBeSavedAndLoaded(): void
    {
        $graph = new Graph();

        $storage = new MemoryStorage();

        $storage->save($graph);

        $this->assertSame($graph, $storage->load());
    }
}
