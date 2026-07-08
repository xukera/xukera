<?php

declare(strict_types=1);

namespace Xukera\Tests;

use PHPUnit\Framework\TestCase;
use Xukera\Core\Graph;
use Xukera\Serialization\JsonSerializer;
use Xukera\Core\Node;

final class JsonSerializerTest extends TestCase
{
    public function testGraphCanBeSerializedToArray(): void
    {
        $graph = new Graph();

        $graph->addNode(new Node('villa_widmann', 'luogo', 'Villa Widmann', [
            'comune' => 'Mira',
        ]));

        $serializer = new JsonSerializer();

        $data = $serializer->toArray($graph);

        $this->assertSame('villa_widmann', $data['nodes'][0]['id']);
        $this->assertSame('luogo', $data['nodes'][0]['type']);
        $this->assertSame('Villa Widmann', $data['nodes'][0]['title']);
        $this->assertSame(['comune' => 'Mira'], $data['nodes'][0]['metadata']);
        $this->assertSame([], $data['relations']);
    }
}
