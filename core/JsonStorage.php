<?php

declare(strict_types=1);

namespace Xukera\Core;

use Xukera\Contracts\StorageInterface;

final class JsonStorage implements StorageInterface
{
    public function __construct(
        private string $filePath
    ) {
    }

    public function save(Graph $graph): void
    {
        $data = [
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

        file_put_contents(
            $this->filePath,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public function load(): Graph
    {
        if (!file_exists($this->filePath)) {
            return new Graph();
        }

        $content = file_get_contents($this->filePath);
        $data = json_decode($content ?: '{}', true);

        $graph = new Graph();

        foreach ($data['nodes'] ?? [] as $nodeData) {
            $graph->addNode(new Node(
                $nodeData['id'],
                $nodeData['type'],
                $nodeData['title'],
                $nodeData['metadata'] ?? []
            ));
        }

        foreach ($data['relations'] ?? [] as $relationData) {
            $source = $graph->getNode($relationData['source']);
            $target = $graph->getNode($relationData['target']);

            if ($source === null || $target === null) {
                continue;
            }

            $graph->addRelation(new Relation(
                $relationData['id'],
                $source,
                $relationData['type'],
                $target,
                $relationData['metadata'] ?? []
            ));
        }

        return $graph;
    }
}
