<?php

declare(strict_types=1);

namespace Xukera\Query;

use Xukera\Core\Node;

/**
 * Risultato di una query XUKERA.
 *
 * Rappresenta una collezione di Node
 * restituiti dal Query Builder.
 */
final class QueryResult
{
    /**
     * @var Node[]
     */
    private array $nodes = [];

    /**
     * @param Node[] $nodes
     */
    public function __construct(array $nodes = [])
    {
        $this->nodes = array_values($nodes);
    }

    public function count(): int
    {
        return count($this->nodes);
    }

    public function first(): ?Node
    {
        return $this->nodes[0] ?? null;
    }

    public function last(): ?Node
    {
        if ($this->nodes === []) {
            return null;
        }

        return $this->nodes[array_key_last($this->nodes)];
    }

    /**
     * @return Node[]
     */
    public function all(): array
    {
        return $this->nodes;
    }

    public function isEmpty(): bool
    {
        return $this->nodes === [];
    }

    /**
     * @return Node[]
     */
    public function toArray(): array
    {
        return $this->nodes;
    }
}