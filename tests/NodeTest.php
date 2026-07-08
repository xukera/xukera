<?php

declare(strict_types=1);

namespace Xukera\Tests;

use PHPUnit\Framework\TestCase;
use Xukera\Core\Node;

final class NodeTest extends TestCase
{
    public function testNodeStoresBasicData(): void
    {
        $node = new Node('villa_widmann', 'luogo', 'Villa Widmann', [
            'comune' => 'Mira',
        ]);

        $this->assertSame('villa_widmann', $node->getId());
        $this->assertSame('luogo', $node->getType());
        $this->assertSame('Villa Widmann', $node->getTitle());
        $this->assertSame(['comune' => 'Mira'], $node->getMetadata());
    }
}
