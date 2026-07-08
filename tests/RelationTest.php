<?php

declare(strict_types=1);

namespace Xukera\Tests;

use PHPUnit\Framework\TestCase;
use Xukera\Core\Node;
use Xukera\Core\Relation;

final class RelationTest extends TestCase
{
    public function testRelationConnectsTwoNodes(): void
    {
        $source = new Node('dario', 'persona', 'Dario');
        $target = new Node('villa_widmann', 'luogo', 'Villa Widmann');

        $relation = new Relation('rel_001', $source, 'visita', $target, [
            'anno' => 2026,
        ]);

        $this->assertSame('rel_001', $relation->getId());
        $this->assertSame($source, $relation->getSource());
        $this->assertSame('visita', $relation->getType());
        $this->assertSame($target, $relation->getTarget());
        $this->assertSame(['anno' => 2026], $relation->getMetadata());
    }
}
