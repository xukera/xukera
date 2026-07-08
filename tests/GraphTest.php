<?php

declare(strict_types=1);

namespace Xukera\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Xukera\Core\Graph;
use Xukera\Core\Node;
use Xukera\Core\Relation;

final class GraphTest extends TestCase
{
    public function testGraphStoresNodes(): void
    {
        $graph = new Graph();
        $node = new Node('villa_widmann', 'luogo', 'Villa Widmann');

        $graph->addNode($node);

        $this->assertTrue($graph->hasNode('villa_widmann'));
        $this->assertSame($node, $graph->getNode('villa_widmann'));
        $this->assertSame(1, $graph->countNodes());
    }

    public function testGraphStoresRelations(): void
    {
        $graph = new Graph();

        $source = new Node('dario', 'persona', 'Dario');
        $target = new Node('villa_widmann', 'luogo', 'Villa Widmann');

        $graph->addNode($source);
        $graph->addNode($target);

        $relation = new Relation('rel_001', $source, 'visita', $target);

        $graph->addRelation($relation);

        $this->assertSame(1, $graph->countRelations());
        $this->assertSame([$relation], $graph->relations());
    }

    public function testGraphRejectsRelationWithMissingNodes(): void
    {
        $graph = new Graph();

        $source = new Node('dario', 'persona', 'Dario');
        $target = new Node('villa_widmann', 'luogo', 'Villa Widmann');

        $this->expectException(InvalidArgumentException::class);

        $graph->addRelation(new Relation('rel_001', $source, 'visita', $target));
    }
}
