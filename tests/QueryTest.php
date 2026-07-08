<?php

declare(strict_types=1);

namespace Xukera\Tests;

use PHPUnit\Framework\TestCase;
use Xukera\Core\Graph;
use Xukera\Core\Node;
use Xukera\Core\Query;
use Xukera\Core\Relation;

final class QueryTest extends TestCase
{
    public function testFindPathReturnsPathBetweenTwoConnectedNodes(): void
    {
        $graph = new Graph();

        $person = new Node('dario', 'persona', 'Dario', [
            'ruolo' => 'custode',
        ]);

        $villa = new Node('villa_widmann', 'luogo', 'Villa Widmann', [
            'comune' => 'Mira',
        ]);

        $graph->addNode($person);
        $graph->addNode($villa);

        $graph->addRelation(new Relation(
            'rel_001',
            $person,
            'visita',
            $villa
        ));

        $path = Query::create($graph)
            ->findPath('dario', 'villa_widmann');

        $this->assertCount(2, $path);
        $this->assertSame('dario', $path[0]->getId());
        $this->assertSame('villa_widmann', $path[1]->getId());
    }
}
