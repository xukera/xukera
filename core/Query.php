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
}
