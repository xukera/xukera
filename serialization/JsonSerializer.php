<?php

declare(strict_types=1);

namespace Xukera\Serialization;

use Xukera\Core\Graph;
use Xukera\Core\Node;
use Xukera\Core\Relation;

final class JsonSerializer
{
    public function toArray(Graph $graph): array
    {
        return [
            'nodes' => array_map(
                fn (Node $node): array => [
                    'id' => $node->getId(),
                    'type' => $node->getType(),
                    'title' => $node->getTitle(),
                    'metadata' => $node->getMetadata(),
                ],
                $graph->nodes()
            ),
            'relations' => array_map(
                fn (Relation $relation): array => [
                    'id' => $relation->getId(),
                    'source' => $relation->getSource()->getId(),
                    'type' => $relation->getType(),
                    'target' => $relation->getTarget()->getId(),
                    'metadata' => $relation->getMetadata(),
                ],
                $graph->relations()
            ),
        ];
    }
}
