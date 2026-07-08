<?php

declare(strict_types=1);

namespace Xukera\Tests;

use PHPUnit\Framework\TestCase;
use Xukera\Core\Graph;
use Xukera\Core\JsonStorage;
use Xukera\Core\Node;
use Xukera\Core\Relation;

final class JsonStorageTest extends TestCase
{
    public function testGraphCanBeSavedAndLoadedFromJsonFile(): void
    {
        $file = sys_get_temp_dir() . '/xukera_test_graph.json';

        if (file_exists($file)) {
            unlink($file);
        }

        $graph = new Graph();

        $person = new Node('dario', 'persona', 'Dario');
        $villa = new Node('villa_widmann', 'luogo', 'Villa Widmann', [
            'comune' => 'Mira',
        ]);

        $graph->addNode($person);
        $graph->addNode($villa);

        $graph->addRelation(new Relation(
            'rel_001',
            $person,
            'visita',
            $villa,
            ['anno' => 2026]
        ));

        $storage = new JsonStorage($file);
        $storage->save($graph);

        $loaded = $storage->load();

        $this->assertTrue($loaded->hasNode('villa_widmann'));
        $this->assertSame('Villa Widmann', $loaded->getNode('villa_widmann')->getTitle());

        $this->assertSame(1, $loaded->countRelations());

        $relation = $loaded->relations()[0];

        $this->assertSame('rel_001', $relation->getId());
        $this->assertSame('dario', $relation->getSource()->getId());
        $this->assertSame('visita', $relation->getType());
        $this->assertSame('villa_widmann', $relation->getTarget()->getId());
        $this->assertSame(['anno' => 2026], $relation->getMetadata());

        unlink($file);
    }
}
