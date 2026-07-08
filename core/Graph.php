<?php

declare(strict_types=1);

namespace Xukera\Core;

/**
 * Grafo della conoscenza di XUKERA.
 *
 * Gestisce l'insieme dei Node
 * e delle Relation.
 */
final class Graph
{
    /**
     * @var Node[]
     */
    private array $nodes = [];

    /**
     * @var Relation[]
     */
    private array $relations = [];

    public function addNode(Node $node): void
    {
        $this->nodes[$node->getId()] = $node;
    }

    public function getNode(string $id): ?Node
    {
        return $this->nodes[$id] ?? null;
    }

    public function hasNode(string $id): bool
    {
        return isset($this->nodes[$id]);
    }

    /**
     * @return Node[]
     */
    public function nodes(): array
    {
        return array_values($this->nodes);
    }

    public function countNodes(): int
    {
        return count($this->nodes);
    }

    public function addRelation(Relation $relation): void
    {
        $sourceId = $relation->getSource()->getId();
        $targetId = $relation->getTarget()->getId();

        if (!$this->hasNode($sourceId)) {
            throw new \InvalidArgumentException("Source node '{$sourceId}' is not in the graph.");
        }

        if (!$this->hasNode($targetId)) {
            throw new \InvalidArgumentException("Target node '{$targetId}' is not in the graph.");
        }

        $this->relations[] = $relation;
    }

    /**
     * @return Relation[]
     */
    public function getRelations(): array
    {
        return $this->relations;
    }

    /**
     * @return Relation[]
     */
    public function relations(): array
    {
        return $this->relations;
    }

    public function countRelations(): int
    {
        return count($this->relations);
    }

    /**
     * @return Node[]
     */
    public function neighbors(Node $node): array
    {
        $neighbors = [];

        foreach ($this->relations as $relation) {
            if ($relation->getSource()->getId() === $node->getId()) {
                $neighbors[$relation->getTarget()->getId()] = $relation->getTarget();
            }

            if ($relation->getTarget()->getId() === $node->getId()) {
                $neighbors[$relation->getSource()->getId()] = $relation->getSource();
            }
        }

        return array_values($neighbors);
    }

    /**
     * @return Node[]
     */
    public function findByType(string $type): array
    {
        $results = [];

        foreach ($this->nodes as $node) {
            if ($node->getType() === $type) {
                $results[] = $node;
            }
        }

        return $results;
    }

    /**
     * @return Node[]
     */
    public function findByMetadata(string $key, mixed $value): array
    {
        $results = [];

        foreach ($this->nodes as $node) {
            $metadata = $node->getMetadata();

            if (
                isset($metadata[$key]) &&
                $metadata[$key] === $value
            ) {
                $results[] = $node;
            }
        }

        return $results;
    }

    /**
     * @return Node[]
     */
    public function search(string $query): array
    {
        $results = [];
        $query = mb_strtolower($query);

        foreach ($this->nodes as $node) {
            $metadata = array_map(
                static fn ($value): string => is_scalar($value) ? (string) $value : json_encode($value),
                $node->getMetadata()
            );

            $haystack = mb_strtolower(
                $node->getTitle() . ' ' .
                $node->getType() . ' ' .
                implode(' ', $metadata)
            );

            if (str_contains($haystack, $query)) {
                $results[$node->getId()] = $node;
            }
        }

        return array_values($results);
    }
}
