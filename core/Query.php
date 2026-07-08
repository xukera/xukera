<?php

declare(strict_types=1);

namespace Xukera\Core;

/**
 * Motore base di interrogazione del Graph.
 */
final class Query
{
    private Graph $graph;

    /**
     * @var Node[]
     */
    private array $result;

    private function __construct(Graph $graph)
    {
        $this->graph = $graph;
        $this->result = $graph->nodes();
    }

    public static function create(Graph $graph): self
    {
        return new self($graph);
    }

    /**
     * @return Node[]
     */
    public function get(): array
    {
        return $this->result;
    }

    /**
     * @return Node[]
     */
    public function all(): array
    {
        return $this->result;
    }

    public function find(string $id): ?Node
    {
        return $this->graph->getNode($id);
    }

    public function whereId(string $id): self
    {
        $this->result = array_values(array_filter(
            $this->result,
            fn (Node $node): bool => $node->getId() === $id
        ));

        return $this;
    }

    public function whereType(string $type): self
    {
        $this->result = array_values(array_filter(
            $this->result,
            fn (Node $node): bool => $node->getType() === $type
        ));

        return $this;
    }
    public function whereMetadata(string $key, mixed $value): self
    {
        $this->result = array_values(array_filter(
        $this->result,
        function (Node $node) use ($key, $value): bool {
            $metadata = $node->getMetadata();

            return array_key_exists($key, $metadata)
                && $metadata[$key] === $value;
        }
        ));

        return $this;
    }
    public function whereProperty(string $key, mixed $value): self
    {
        $this->result = array_values(array_filter(
            $this->result,
            fn (Node $node): bool => $node->getProperty($key) === $value
        ));

        return $this;
    }

    public function count(): int
    {
        return count($this->result);
    }

    public function first(): ?Node
    {
        return $this->result[0] ?? null;
    }

/**
 * Naviga verso i nodi target delle relazioni uscenti
 * dai nodi attualmente selezionati.
 *
 * @return self
 */
public function outgoing(?string $type = null): self
{
    $currentIds = array_map(
        fn (Node $node): string => $node->getId(),
        $this->result
    );

    $results = [];

    foreach ($this->graph->relations() as $relation) {
        if (!in_array($relation->getSource()->getId(), $currentIds, true)) {
            continue;
        }

        if ($type !== null && $relation->getType() !== $type) {
            continue;
        }

        $target = $relation->getTarget();
        $results[$target->getId()] = $target;
    }

    $this->result = array_values($results);

    return $this;
}

/**
 * Naviga verso i nodi source delle relazioni entranti
 * nei nodi attualmente selezionati.
 *
 * @return self
 */
public function incoming(?string $type = null): self
{
    $currentIds = array_map(
        fn (Node $node): string => $node->getId(),
        $this->result
    );

    $results = [];

    foreach ($this->graph->relations() as $relation) {
        if (!in_array($relation->getTarget()->getId(), $currentIds, true)) {
            continue;
        }

        if ($type !== null && $relation->getType() !== $type) {
            continue;
        }

        $source = $relation->getSource();
        $results[$source->getId()] = $source;
    }

    $this->result = array_values($results);

    return $this;
}

/**
 * Restituisce i nodi vicini dei nodi attualmente selezionati.
 *
 * @return self
 */
public function neighbors(): self
{
    $results = [];

    foreach ($this->result as $node) {
        foreach ($this->graph->neighbors($node) as $neighbor) {
            $results[$neighbor->getId()] = $neighbor;
        }
    }

    $this->result = array_values($results);

    return $this;
}

/**
 * Trova il percorso più breve tra due nodi.
 *
 * @return Node[]
 */
public function findPath(string $fromId, string $toId): array
{
    $start = $this->graph->getNode($fromId);
    $target = $this->graph->getNode($toId);

    if ($start === null || $target === null) {
        return [];
    }

    $queue = [
        [$start],
    ];

    $visited = [
        $start->getId() => true,
    ];

    while ($queue !== []) {
        $path = array_shift($queue);
        $lastNode = $path[count($path) - 1];

        if ($lastNode->getId() === $target->getId()) {
            return $path;
        }

        foreach ($this->graph->neighbors($lastNode) as $neighbor) {
            if (isset($visited[$neighbor->getId()])) {
                continue;
            }

            $visited[$neighbor->getId()] = true;

            $newPath = $path;
            $newPath[] = $neighbor;

            $queue[] = $newPath;
        }
    }

    return [];
}


}
