<?php

declare(strict_types=1);

namespace Xukera\Tests;

use PHPUnit\Framework\TestCase;
use Xukera\Core\Graph;
use Xukera\Core\JsonStorage;
use Xukera\Core\Node;

final class JsonStorageTest extends TestCase
{
    public function testGraphCanBeSavedAndLoadedFromJsonFile(): void
    {
        $file = sys_get_temp_dir() . '/xukera_test_graph.json';

        if (file_exists($file)) {
            unlink($file);
        }

        $graph = new Graph();
        $graph->addNode(new Node('villa_widmann', 'luogo', 'Villa Widmann', [
            'comune' => 'Mira',
        ]));

        $storage = new JsonStorage($file);
        $storage->save($graph);

        $loaded = $storage->load();

        $this->assertTrue($loaded->hasNode('villa_widmann'));
        $this->assertSame('Villa Widmann', $loaded->getNode('villa_widmann')->getTitle());

        unlink($file);
    }
}
