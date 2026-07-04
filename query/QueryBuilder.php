<?php

declare(strict_types=1);

namespace Xukera\Query;

use RuntimeException;
use Xukera\Core\Node;

/**
 * Costruisce una query sul Knowledge Graph.
 */
final class QueryBuilder
{
    private ?QueryEngine $engine;

    private ?string $id = null;

    private ?string $type = null;

    private array $filters = [];

    private ?Node $relatedTo = null;

    private ?int $limit = null;

    public function __construct(?QueryEngine $engine = null)
    {
        $this->engine = $engine;
    }

    public function id(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function where(string $key, string $operator, mixed $value): self
    {
        $this->filters[] = [
            'key' => $key,
            'operator' => $operator,
            'value' => $value,
        ];

        return $this;
    }

    public function relatedTo(Node $node): self
    {
        $this->relatedTo = $node;

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function get(): QueryResult
    {
        if ($this->engine === null) {
            throw new RuntimeException('QueryBuilder non collegato a un QueryEngine.');
        }

        return $this->engine->execute($this);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getRelatedTo(): ?Node
    {
        return $this->relatedTo;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}